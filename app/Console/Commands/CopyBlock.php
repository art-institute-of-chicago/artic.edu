<?php

namespace App\Console\Commands;

use App\Libraries\BlockCopy;
use App\Libraries\BlockCopyException;
use App\Models\Vendor\Block;
use Illuminate\Console\Command;

/** Copies a block (with its children and media) onto another model. */
class CopyBlock extends Command
{
    protected $signature = 'block:copy {blockId} {--to=} {--position=}';

    protected $description = 'Copy a block (with its children and media) onto another model.';

    public function handle(): int
    {
        $to = (string) $this->option('to');

        if ($to === '' || !str_contains($to, ':')) {
            $this->error('Pass the target as --to={moduleAlias}:{id}, e.g. --to=highlights:11');

            return self::FAILURE;
        }

        [$alias, $targetId] = explode(':', $to, 2);

        $source = Block::find((int) $this->argument('blockId'));

        if (!$source) {
            $this->error('Block ' . $this->argument('blockId') . ' not found.');

            return self::FAILURE;
        }

        $class = BlockCopy::modelClass($alias);

        if (!$class) {
            $this->error("Unknown target module '{$alias}'.");

            return self::FAILURE;
        }

        if (!$class::find($targetId)) {
            $this->error("Target '{$alias}:{$targetId}' not found.");

            return self::FAILURE;
        }

        $position = $this->option('position');

        if ($position !== null && (!is_numeric($position) || (int) $position < 1)) {
            $this->error('--position must be a positive integer.');

            return self::FAILURE;
        }

        try {
            $result = BlockCopy::copy($source, $alias, $targetId, $position === null ? null : (int) $position);
        } catch (BlockCopyException $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        foreach ($result['warnings'] as $warning) {
            $this->warn($warning);
        }

        $clone = $result['clone'];

        $this->info(sprintf(
            'Copied block %s (%s) from %s:%s to %s:%s -> new block %s (children: %d, media rows: %d)',
            $source->getKey(),
            $source->type,
            $source->blockable_type,
            $source->blockable_id,
            $alias,
            $clone->blockable_id,
            $clone->getKey(),
            $result['children'],
            $result['media']
        ));

        return self::SUCCESS;
    }
}

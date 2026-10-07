<?php

namespace App\Libraries;

use App\Models\Vendor\Block;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/** Shared block-copy logic used by the block:copy command and the Block Copy admin page. */
class BlockCopy
{
    /** Message shown when the posted block set no longer matches the stored set. */
    protected const REORDER_STALE = 'The block list changed since this page was loaded. Reload and try again.';

    /** [alias => ['label' => string, 'blocks' => string[]]] */
    protected static ?array $modules = null;

    /** Auto-detects copyable modules (morph-map aliases with a Twill form exposing blocks). */
    public static function modules(): array
    {
        if (static::$modules !== null) {
            return static::$modules;
        }

        $forms = [];

        foreach (File::allFiles(resource_path('views/twill')) as $file) {
            if ($file->getFilename() === 'form.blade.php') {
                $key = strtolower(preg_replace('/[^a-z0-9]/i', '', $file->getRelativePath()));
                $forms[$key][] = $file;
            }
        }

        $modules = [];

        foreach (array_keys(Relation::morphMap() ?: []) as $alias) {
            $class = Relation::getMorphedModel($alias);

            if (!is_string($class) || !class_exists($class) || !method_exists($class, 'blocks')) {
                continue;
            }

            $aliasKey = strtolower(preg_replace('/[^a-z0-9]/i', '', $alias));
            $aliasKeySingular = str_replace('s', '', $aliasKey);

            $types = [];

            foreach ($forms as $dirKey => $files) {
                if (
                    $dirKey !== $aliasKey
                    && !str_starts_with($dirKey, $aliasKey)
                    && str_replace('s', '', $dirKey) !== $aliasKeySingular
                ) {
                    continue;
                }

                foreach ($files as $file) {
                    $types = array_merge($types, static::blockTypes($file->getPathname()));
                }
            }

            $types = array_values(array_unique($types));

            if (count($types) === 0) {
                continue;
            }

            $modules[$alias] = ['label' => Str::headline($alias), 'blocks' => $types];
        }

        uasort($modules, fn ($a, $b) => $a['label'] <=> $b['label']);

        return static::$modules = $modules;
    }

    /** Returns the block types allowed on the alias, or null when undeterminable. */
    public static function allowedBlocks(string $alias): ?array
    {
        return static::modules()[$alias]['blocks'] ?? null;
    }

    /** Resolves a morph-map alias (or class name) to a model class, or null. */
    public static function modelClass(string $alias): ?string
    {
        $class = Relation::getMorphedModel($alias) ?: (class_exists($alias) ? $alias : null);

        return is_string($class) && class_exists($class) ? $class : null;
    }

    /** Returns [id => "Title (id 12)"] for the module's records, newest first. */
    public static function recordOptions(string $alias, int $limit = 2000): array
    {
        $class = static::modelClass($alias);

        if (!$class) {
            return [];
        }

        $table = (new $class())->getTable();
        $order = Schema::hasColumn($table, 'updated_at') ? 'updated_at' : 'id';
        $label = Schema::hasColumn($table, 'title') ? 'title' : 'id';

        $options = [];

        foreach ($class::query()->orderByDesc($order)->limit($limit)->get() as $record) {
            $id = $record->getKey();
            $title = $record->{$label};

            $options[$id] = ($title !== null && $title !== '' ? $title : $id) . " (id {$id})";
        }

        return $options;
    }

    /** First non-empty scalar string in the block's content, stripped and truncated. */
    public static function previewText(?Block $block, int $limit = 90): string
    {
        if (!$block) {
            return '';
        }

        $value = static::firstScalar($block->content);

        return $value === null ? '' : Str::limit(strip_tags($value), $limit);
    }

    /**
     * Builds the admin-page row for each root block on a record, with batched child/media counts.
     *
     * @return array<int, array{id: int, position: int, type: string, preview: string, allowed: ?bool, editor: ?string, children: int, media: int, is_new: bool}>
     */
    public static function blockList(Model $record, ?array $allowed = null, ?int $lastPasteId = null): array
    {
        $blocks = $record->blocks()->whereNull('parent_id')->orderBy('position')->get();

        $ids = $blocks->pluck('id')->all();

        $children = [];
        $media = [];

        if ($ids !== []) {
            $children = DB::table(config('twill.blocks_table', 'twill_blocks'))
                ->whereIn('parent_id', $ids)
                ->groupBy('parent_id')
                ->selectRaw('parent_id, count(*) as aggregate')
                ->pluck('aggregate', 'parent_id')
                ->all();

            $media = DB::table(config('twill.mediables_table', 'twill_mediables'))
                ->where('mediable_type', 'blocks')
                ->whereIn('mediable_id', $ids)
                ->whereNull('deleted_at')
                ->groupBy('mediable_id')
                ->selectRaw('mediable_id, count(*) as aggregate')
                ->pluck('aggregate', 'mediable_id')
                ->all();
        }

        return $blocks->map(function (Block $block) use ($allowed, $lastPasteId, $children, $media) {
            $id = $block->getKey();

            return [
                'id' => $id,
                'position' => (int) $block->position,
                'type' => $block->type,
                'preview' => static::previewText($block),
                'allowed' => $allowed === null ? null : in_array($block->type, $allowed, true),
                // Twill treats a null editor_name and 'default' as the same block editor group.
                'editor' => in_array($block->editor_name, [null, 'default'], true) ? null : $block->editor_name,
                'children' => (int) ($children[$id] ?? 0),
                'media' => (int) ($media[$id] ?? 0),
                'is_new' => $lastPasteId !== null && $id === $lastPasteId,
            ];
        })->all();
    }

    /**
     * Copies a block (children + media) onto another record.
     *
     * @return array{clone: Block, position: int, children: int, media: int, warnings: string[]}
     */
    public static function copy(Block $source, string $alias, int|string $recordId, ?int $position): array
    {
        if ($source->parent_id !== null) {
            throw new BlockCopyException("Block #{$source->getKey()} is a nested child block; copy a top-level block instead.");
        }

        $class = static::modelClass($alias);

        if (!$class) {
            throw new BlockCopyException("Unknown target module '{$alias}'.");
        }

        $target = $class::find($recordId);

        if (!$target) {
            throw new BlockCopyException("Target '{$alias}:{$recordId}' not found.");
        }

        $allowed = static::allowedBlocks($alias);

        if ($allowed !== null && !in_array($source->type, $allowed, true)) {
            $sorted = $allowed;
            sort($sorted);

            throw new BlockCopyException(
                "Block type '{$source->type}' is not allowed on {$alias}. Allowed: " . implode(', ', $sorted)
            );
        }

        $editor = $source->editor_name;

        $siblings = fn () => DB::table(config('twill.blocks_table', 'blocks'))
            ->where('blockable_type', $target->getMorphClass())
            ->where('blockable_id', $target->getKey())
            ->whereNull('parent_id')
            ->when(
                in_array($editor, [null, 'default'], true),
                fn ($q) => $q->where(fn ($q) => $q->whereNull('editor_name')->orWhere('editor_name', 'default')),
                fn ($q) => $q->where('editor_name', $editor)
            );

        if ($position === null) {
            $position = (int) $siblings()->max('position') + 1;
        } elseif ($position < 1) {
            throw new BlockCopyException('Position must be a positive integer.');
        } else {
            $siblings()->where('position', '>=', $position)->increment('position');
        }

        $clone = BlockCloner::cloneTo($source, $target, $position);

        $warnings = [];

        if ($editor !== null) {
            $existingEditors = DB::table(config('twill.blocks_table', 'blocks'))
                ->where('blockable_type', $target->getMorphClass())
                ->where('blockable_id', $target->getKey())
                ->whereNull('parent_id')
                ->whereNotNull('editor_name')
                ->where('id', '!=', $clone->getKey())
                ->distinct()
                ->pluck('editor_name');

            if ($existingEditors->isNotEmpty() && !$existingEditors->contains($editor)) {
                $warnings[] = "Block kept editor_name '{$editor}', which is not used on this target; it may not appear in the form.";
            }
        }

        $media = DB::table(config('twill.mediables_table', 'twill_mediables'))
            ->where('mediable_type', $clone->getMorphClass())
            ->where('mediable_id', $clone->getKey())
            ->whereNull('deleted_at')
            ->count();

        return [
            'clone' => $clone,
            'position' => $position,
            'children' => static::descendantCount($clone),
            'media' => $media,
            'warnings' => $warnings,
        ];
    }

    /**
     * Rewrites 1-based positions for one block-editor group in the submitted order.
     *
     * @param int[] $ids
     * @return array{blocks: array, editor: ?string}
     */
    public static function reorder(Model $record, array $ids, ?string $editorName = null): array
    {
        if ($ids === []) {
            throw new BlockCopyException('No block order was submitted.');
        }

        $order = [];

        foreach ($ids as $id) {
            if (!is_numeric($id)) {
                throw new BlockCopyException(static::REORDER_STALE);
            }

            $order[] = (int) $id;
        }

        $current = DB::table(config('twill.blocks_table', 'blocks'))
            ->where('blockable_type', $record->getMorphClass())
            ->where('blockable_id', $record->getKey())
            ->whereNull('parent_id')
            ->when(
                in_array($editorName, [null, 'default'], true),
                fn ($q) => $q->where(fn ($q) => $q->whereNull('editor_name')->orWhere('editor_name', 'default')),
                fn ($q) => $q->where('editor_name', $editorName)
            )
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $expected = $current;
        $submitted = $order;
        sort($expected);
        sort($submitted);

        if ($expected !== $submitted) {
            throw new BlockCopyException(static::REORDER_STALE);
        }

        DB::transaction(function () use ($order) {
            foreach ($order as $index => $id) {
                DB::table(config('twill.blocks_table', 'blocks'))
                    ->where('id', $id)
                    ->update(['position' => $index + 1]);
            }
        });

        return ['blocks' => static::blockList($record, null, null), 'editor' => $editorName];
    }

    /** Collects getBlocksForEditor types from a form, following includes one level deep. */
    protected static function blockTypes(string $path): array
    {
        $contents = File::get($path);

        if (preg_match_all("/@include\(\s*'([^']+)'/", $contents, $includes)) {
            foreach ($includes[1] as $include) {
                $included = resource_path('views/' . str_replace('.', '/', $include) . '.blade.php');

                if (File::exists($included)) {
                    $contents .= "\n" . File::get($included);
                }
            }
        }

        $types = [];

        if (preg_match_all('/getBlocksForEditor\(\[(.*?)\]/s', $contents, $calls)) {
            foreach ($calls[1] as $call) {
                if (preg_match_all("/'([^']+)'/", $call, $blocks)) {
                    foreach ($blocks[1] as $block) {
                        if (strlen($block) > 1) {
                            $types[] = $block;
                        }
                    }
                }
            }
        }

        return $types;
    }

    /** Returns the first non-empty string found recursively. */
    protected static function firstScalar(mixed $value): ?string
    {
        if (is_string($value)) {
            $trimmed = trim($value);

            return $trimmed === '' ? null : $trimmed;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                $found = static::firstScalar($item);

                if ($found !== null) {
                    return $found;
                }
            }
        }

        return null;
    }

    protected static function descendantCount(Block $block): int
    {
        $count = 0;

        foreach ($block->children()->get() as $child) {
            $count += 1 + static::descendantCount($child);
        }

        return $count;
    }
}

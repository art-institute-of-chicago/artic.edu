<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        $accordionBlocks = Block::where('type', 'ranged_accordion')->orderBy('blockable_id', 'asc')->orderBy('position', 'asc')->get();

        $initial = null;
        $ending = null;

        foreach ($accordionBlocks as $accordion) {
            if (!empty($accordion->content['type']) && ($accordion->content['type'] == 'start') && $initial && ($accordion['position'] !== $initial->position) && ($accordion['blockable_id'] !== $initial->blockable_id)) {
                $accordion->delete();
                continue;
            }

            if (!empty($accordion->content['type']) && ($accordion->content['type'] == 'start') && !$ending) {
                $initial = (object)[
                    'id' => $accordion['id'],
                    'position' => $accordion['position'],
                    'blockable_id' => $accordion['blockable_id']
                ];
            }

            if (!empty($accordion->content['type']) && ($accordion->content['type'] == 'end') && $initial && !$ending) {
                $ending = (object)[
                    'id' => $accordion['id'],
                    'position' => $accordion['position'],
                    'blockable_id' => $accordion['blockable_id']
                ];
            }

            if (($initial && $ending) && ($initial->blockable_id == $ending->blockable_id)) {
                $position = 1;
                $nestedBlocks = Block::where('blockable_id', $initial->blockable_id)
                    ->whereBetween('position', [($initial->position + 1), ($ending->position - 1)])
                    ->orderBy('position', 'asc')
                    ->get();

                foreach ($nestedBlocks as $block) {
                    $block['child_key'] = 'accordion_items';
                    $block['parent_id'] = $initial->id;
                    $block['position'] = $position;
                    $block->save(); // Added save() to persist changes
                    $position++;
                }

                Block::where('id', $ending->id)->delete();

                $initial = null;
                $ending = null;
            }
        }
    }

    public function down(): void
    {
        // PRESENTISM
    }
};

<?php

namespace App\Libraries;

use App\Models\Vendor\Block;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/** Deep-copies a block, its children and its media rows onto another blockable model. */
class BlockCloner
{
    public static function cloneTo(Block $source, Model $parent, ?int $position = null): Block
    {
        return static::cloneBlock($source, $parent, $position, null);
    }

    public static function deleteSubtree(Block $block): void
    {
        foreach ($block->children()->get() as $child) {
            static::deleteSubtree($child);
        }

        DB::table(config('twill.mediables_table', 'twill_mediables'))
            ->where('mediable_type', $block->getMorphClass())
            ->where('mediable_id', $block->getKey())
            ->delete();

        $block->delete();
    }

    protected static function cloneBlock(Block $source, Model $parent, ?int $position, ?int $parentId): Block
    {
        $clone = new Block();
        $clone->blockable_id = $parent->getKey();
        $clone->blockable_type = $parent->getMorphClass();
        $clone->position = $position ?? $source->position;
        $clone->content = $source->content;
        $clone->type = $source->type;
        $clone->child_key = $source->child_key;
        $clone->parent_id = $parentId;
        $clone->editor_name = $source->editor_name;
        $clone->save();

        static::copyMedias($source, $clone);

        foreach ($source->children()->get() as $child) {
            static::cloneBlock($child, $parent, $child->position, $clone->getKey());
        }

        return $clone;
    }

    protected static function copyMedias(Block $source, Block $clone): void
    {
        $table = config('twill.mediables_table', 'twill_mediables');

        $rows = DB::table($table)
            ->where('mediable_type', $source->getMorphClass())
            ->where('mediable_id', $source->getKey())
            ->whereNull('deleted_at')
            ->get();

        foreach ($rows as $row) {
            DB::table($table)->insert([
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'mediable_id' => $clone->getKey(),
                'mediable_type' => $clone->getMorphClass(),
                'media_id' => $row->media_id,
                'crop_x' => $row->crop_x,
                'crop_y' => $row->crop_y,
                'crop_w' => $row->crop_w,
                'crop_h' => $row->crop_h,
                'role' => $row->role,
                'crop' => $row->crop,
                'lqip_data' => $row->lqip_data,
                'ratio' => $row->ratio,
                'metadatas' => $row->metadatas ?? '{}',
                'locale' => $row->locale ?? 'en',
                'position' => $row->position ?? 1,
            ]);
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        $blocks = Block::where('type', 'gallery_new_item')
                    ->whereNull('content->gallery_item_type')
                    ->get();

        foreach ($blocks as $block) {
            $content = $block['content'];

            $content['gallery_item_type'] = \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM;

            // Set the entire content attribute
            $block['content'] = $content;
            $block->save();
        }

        // There are also a few blocks with bad data. Fix those.
        $blocks = Block::where('type', 'gallery_new_item')
            ->where('content->gallery_item_type', '\\App\\Models\\Vendor\\Block::GALLERY_ITEM_TYPE_CUSTOM')
            ->get();

        foreach ($blocks as $block) {
            $content = $block['content'];

            $content['gallery_item_type'] = \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM;

            // Set the entire content attribute
            $block['content'] = $content;
            $block->save();
        }
    }

    public function down(): void
    {
        // Nada
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        // The previous migration may have missed some repeater items. Since we've made these items
        // translable, newly entered content is structurd fine, but older content may not be.
        // The migration checks the blocks we may have missed, and only changes blocks with the
        // incorrect structure.
        //
        // @see 2025_05_06_163206_move_educator_resource_translated_columns_to_educator_resource_translations
        // @see 2025_05_20_104012_restructure_all_translatable_blocks


        $translatedBlocks = [
            'gallery_new_item' => [
                'translatedFields' => ['captionTitle', 'captionText', 'linkLabel', 'captionAddendum'],
            ],
            'gallery_new' => [
                'translatedFields' => ['title', 'description'],
            ],
            'link' => [
                'translatedFields' => ['title', 'link'],
            ],
            'list_item' => [
                'translatedFields' => ['tag', 'header', 'description'],
            ],
            'media_embed' => [
                'translatedFields' => ['caption', 'caption_title'],
            ],
            'split_block' => [
                'translatedFields' => ['paragraph'],
            ],
        ];

        foreach ($translatedBlocks as $blockType => $blockFields) {
            $blocks = Block::where('type', $blockType)->get();

            foreach ($blocks as $block) {
                foreach ($blockFields as $fields) {
                    foreach ($fields as $field) {
                        if (!empty($block['content'][$field] ?? '')) {
                            $content = $block['content'];
                            $fieldValue = $content[$field];

                            // Check if the field is already an array (already translated)
                            if (is_array($fieldValue)) {
                                continue;
                            }

                            $translatedContent = [
                                'es' => null,
                                'en' => $fieldValue
                            ];
                            // Update the field in the content array
                            $content[$field] = $translatedContent;

                            // // Set the entire content attribute
                            $block['content'] = $content;
                            $block->save();
                        }
                    }
                }
            }
        }
    }

    public function down(): void
    {
        // Nope
    }
};

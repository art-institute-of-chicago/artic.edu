<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        // A previous migration only updated the structure of these blocks on content referenced by `educatorResource`s.
        // But the restructuring of these blocks affects all instances of them, not just the ones used on educator resources.
        // This migration makes that same change on all instances of these blocks.
        //
        // @see 2025_05_06_163206_move_educator_resource_translated_columns_to_educator_resource_translations


        $translatedBlocks = [
            'artwork' => [
                'translatedFields' => ['captionAddendum'],
            ],
            'audio_player' => [
                'translatedFields' => ['title_display', 'transcript', 'caption_title', 'caption'],
            ],
            'button' => [
                'translatedFields' => ['title', 'link'],
            ],
            'editorial_block' => [
                'translatedFields' => ['heading', 'body'],
            ],
            'gallery_new' => [
                'translatedFields' => ['title', 'description'],
            ],
            'link' => [
                'translatedFields' => ['title', 'link'],
            ],
            'media_embed' => [
                'translatedFields' => ['caption_title', 'caption'],
            ],
            'membership_banner' => [
                'translatedFields' => ['headline', 'short_copy', 'link_text'],
            ],
            'mobile_app' => [
                'translatedFields' => ['callout'],
            ],
            'newsletter_signup_inline' => [
                'translatedFields' => ['copy'],
            ],
            'paragraph' => [
                'translatedFields' => ['paragraph'],
            ],
            'quote' => [
                'translatedFields' => ['quote', 'attribution'],
            ],
            'video' => [
                'translatedFields' => ['caption_title', 'caption'],
            ],
            'accordion_item' => [
                'translatedFields' => ['header', 'description'],
            ],
            'gallery_new_item' => [
                'translatedFields' => ['captionTitle', 'captionText', 'linkLabel', 'captionAddendum'],
            ],
            'tag' => [
                'translatedFields' => ['tag', 'header', 'description'],
            ],
            'timeline_item' => [
                'translatedFields' => ['title', 'description', 'image'],
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
                            // Set the entire content attribute
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

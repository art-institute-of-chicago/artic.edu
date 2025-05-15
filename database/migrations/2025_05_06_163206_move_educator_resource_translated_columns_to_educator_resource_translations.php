<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        $normalIds = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151];

        // These ids are related via their translated copies and need to have both 'es' and 'en' locale's added to the column
        $translatedIds = [
            ['es' => 126, 'en' => 124],
            ['es' => 128, 'en' => 127],
            ['es' => 130, 'en' => 129],
            ['es' => 132, 'en' => 131],
            ['es' => 135, 'en' => 134],
            ['es' => 137, 'en' => 136],
            ['es' => 139, 'en' => 138],
            ['es' => 141, 'en' => 140],
            ['es' => 153, 'en' => 152],
            ['es' => 155, 'en' => 154],
            ['es' => 157, 'en' => 156],
            ['es' => 159, 'en' => 158],
            ['es' => 161, 'en' => 160]
        ];

        // Known translated blocks and fields present
        //
        // These need to be manually mapped because if the fields within a block isn't substantial
        // then the block doesn't cast an empty {'en' => '', 'es' => ''} which would identify translated fields
        // So to set the property and it's values it has to be manually defined :/

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

        //   Normal Attributes
        //
        //     'published',
        //     'public',
        //     'publish_start_date',
        //     'publish_end_date',
        //     'has_media_content'
        //
        //   Translated Attributes
        //
        //     'title',
        //     'title_display',
        //     'listing_description',
        //     'short_description',
        //     'meta_title',
        //     'meta_description',

        // Translated table is the same as a model table just with a 'locale' identifier

        foreach ($normalIds as $id) {
            $resource = DB::table('educator_resources')->where('id', $id)->first();

            if ($resource) {
                // Check if translation entry exists
                $translationExists = DB::table('educator_resource_translations')
                    ->where('educator_resource_id', $id)
                    ->exists();

                if (!$translationExists) {
                    // Create new translation entry
                    DB::table('educator_resource_translations')->insert([
                        'educator_resource_id' => $id,
                        'locale' => 'en',
                        'title' => $resource->title ?? null,
                        'title_display' => $resource->title_display ?? null,
                        'listing_description' => $resource->listing_description ?? null,
                        'short_description' => $resource->short_description ?? null,
                        'meta_title' => $resource->meta_title ?? null,
                        'meta_description' => $resource->meta_description ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    // Update existing translation
                    DB::table('educator_resource_translations')
                        ->where('educator_resource_id', $id)
                        ->update([
                            'locale' => 'en',
                            'title' => $resource->title ?? null,
                            'title_display' => $resource->title_display ?? null,
                            'listing_description' => $resource->listing_description ?? null,
                            'short_description' => $resource->short_description ?? null,
                            'meta_title' => $resource->meta_title ?? null,
                            'meta_description' => $resource->meta_description ?? null,
                            'updated_at' => now()
                        ]);
                }

                // Normal block field conversions

                $blocks = Block::where('blockable_type', 'educatorResources')->where('blockable_id', $id)->get();

                foreach ($blocks as $block) {
                    if (!empty($translatedBlocks[$block->type])) {
                        $blockFields = $translatedBlocks[$block->type]['translatedFields'];
                        foreach ($blockFields as $field) {
                            if (!empty($block['content'][$field])) {
                                $content = $block['content'];
                                $translatedContent = [
                                    'es' => null,
                                    'en' => $content[$field]
                                ];
                                // Update the field in the content array
                                $content[$field] = $translatedContent;
                                // Set the entire content attribute
                                $block['content'] = $content;
                                $block->save();

                                dump($block->type . ': ' . json_encode($block['content'][$field]));
                            }
                        }
                    }
                }
            }
        }

        // For translated ID's set the correct locale
        foreach ($translatedIds as $pair) {
            // Get the English version data
            $enResource = DB::table('educator_resources')->where('id', $pair['en'])->first();

            if ($enResource) {
                // Check if English translation entry exists
                $enTranslationExists = DB::table('educator_resource_translations')
                    ->where('educator_resource_id', $pair['en'])
                    ->exists();

                if (!$enTranslationExists) {
                    // Create new English translation
                    DB::table('educator_resource_translations')->insert([
                        'educator_resource_id' => $pair['en'],
                        'locale' => 'en',
                        'title' => $enResource->title ?? null,
                        'title_display' => $enResource->title_display ?? null,
                        'listing_description' => $enResource->listing_description ?? null,
                        'short_description' => $enResource->short_description ?? null,
                        'meta_title' => $enResource->meta_title ?? null,
                        'meta_description' => $enResource->meta_description ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    // Update existing English translation
                    DB::table('educator_resource_translations')
                        ->where('educator_resource_id', $pair['en'])
                        ->update([
                            'locale' => 'en',
                            'title' => $enResource->title ?? null,
                            'title_display' => $enResource->title_display ?? null,
                            'listing_description' => $enResource->listing_description ?? null,
                            'short_description' => $enResource->short_description ?? null,
                            'meta_title' => $enResource->meta_title ?? null,
                            'meta_description' => $enResource->meta_description ?? null,
                            'updated_at' => now()
                        ]);
                }
            }

            // Get the Spanish version
            $esResource = DB::table('educator_resources')->where('id', $pair['es'])->first();

            if ($esResource) {
                // Check if Spanish translation exists
                $esTranslationExists = DB::table('educator_resource_translations')
                    ->where('educator_resource_id', $pair['en'])
                    ->where('locale', 'es')
                    ->exists();

                if (!$esTranslationExists) {
                    // Create Spanish translation for the English record
                    DB::table('educator_resource_translations')->insert([
                        'educator_resource_id' => $pair['en'],
                        'locale' => 'es',
                        'title' => $esResource->title ?? null,
                        'title_display' => $esResource->title_display ?? null,
                        'listing_description' => $esResource->listing_description ?? null,
                        'short_description' => $esResource->short_description ?? null,
                        'meta_title' => $esResource->meta_title ?? null,
                        'meta_description' => $esResource->meta_description ?? null,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    // Update existing Spanish translation for the English record
                    DB::table('educator_resource_translations')
                        ->where('educator_resource_id', $pair['en'])
                        ->where('locale', 'es')
                        ->update([
                            'title' => $esResource->title ?? null,
                            'title_display' => $esResource->title_display ?? null,
                            'listing_description' => $esResource->listing_description ?? null,
                            'short_description' => $esResource->short_description ?? null,
                            'meta_title' => $esResource->meta_title ?? null,
                            'meta_description' => $esResource->meta_description ?? null,
                            'updated_at' => now()
                        ]);
                }

                // Delete the Spanish record after data is moved
                DB::table('educator_resources')->where('id', $pair['es'])->delete();
            }

            // ES to EN block field squashing

            $englishBlocks = Block::where('blockable_type', 'educatorResources')
                ->where('blockable_id', $pair['en'])
                ->get()
                ->keyBy('position');

            $spanishBlocks = Block::where('blockable_type', 'educatorResources')
                ->where('blockable_id', $pair['es'])
                ->get()
                ->keyBy('position');

            // Process English blocks first
            foreach ($englishBlocks as $position => $enBlock) {
                if (!empty($translatedBlocks[$enBlock->type])) {
                    $blockFields = $translatedBlocks[$enBlock->type]['translatedFields'];
                    $content = $enBlock['content'];
                    $changed = false;

                    foreach ($blockFields as $field) {
                        if (!empty($content[$field])) {
                            // Create translated content structure with English content
                            $translatedContent = [
                                'en' => $content[$field],
                                'es' => null
                            ];

                            // If there's a matching Spanish block, add its content
                            if (
                                isset($spanishBlocks[$position]) &&
                                $spanishBlocks[$position]->type === $enBlock->type &&
                                !empty($spanishBlocks[$position]['content'][$field])
                            ) {
                                $translatedContent['es'] = $spanishBlocks[$position]['content'][$field];
                            }

                            // Update the field in the content array
                            $content[$field] = $translatedContent;
                            $changed = true;

                            dump("Updated $field in English {$enBlock->type} at position $position");
                        }
                    }

                    if ($changed) {
                        // Set the entire content attribute
                        $enBlock['content'] = $content;
                        $enBlock->save();
                    }
                }
            }

            // Process Spanish blocks that don't have matching English blocks
            foreach ($spanishBlocks as $position => $esBlock) {
                // Skip if there's already an English block at this position
                if (isset($englishBlocks[$position])) {
                    continue;
                }

                if (!empty($translatedBlocks[$esBlock->type])) {
                    $blockFields = $translatedBlocks[$esBlock->type]['translatedFields'];
                    $content = $esBlock['content'];
                    $changed = false;

                    foreach ($blockFields as $field) {
                        if (!empty($content[$field])) {
                            // Create translated content structure with Spanish content
                            $translatedContent = [
                                'en' => null,
                                'es' => $content[$field]
                            ];

                            // Update the field in the content array
                            $content[$field] = $translatedContent;
                            $changed = true;

                            dump("Added Spanish-only {$esBlock->type} at position $position");
                        }
                    }

                    if ($changed) {
                        $esBlock['content'] = $content;

                        // Update the block to be associated with the English resource
                        $esBlock->blockable_id = $pair['en'];
                        $esBlock->save();
                    }
                }
            }
        }

        // Drop the translated columns from educator_resources
        Schema::table('educator_resources', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'title_display',
                'listing_description',
                'short_description',
                'meta_title',
                'meta_description'
            ]);
        });
    }

    public function down(): void
    {
        // I'm not even gonna try lol
    }
};

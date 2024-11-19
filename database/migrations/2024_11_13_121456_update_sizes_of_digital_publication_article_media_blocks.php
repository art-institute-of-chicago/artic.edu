<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;

return new class extends Migration
{
    public function up(): void
    {
        $types = [
            '360_embed' => [],
            'artwork' => [],
            'image_slider' => [],
            'layered_image_viewer' => [],
            'media_embed' => [],
            'mirador_embed' => [],
            'table' => [],
            'video' => ['use_alt_background'],
            'vtour_embed' => [],
        ];

        foreach ($types as $type => $fieldsToSetToTrue) {
            // Find all blocks of digitalPublicationArticles
            $digiPubBlocks = Block::where('type', $type)
                ->where('blockable_type', 'digitalPublicationArticles')
                ->get();

            // Update the content JSON column for image block on digital publication articles
            foreach ($digiPubBlocks as $block) {
                $content = $block->content;
                $content['size'] = 'l';

                foreach ($fieldsToSetToTrue as $field) {
                    $content[$field] = true;
                }

                // Update the block with the new JSON
                $block->content = $content;
                $block->save();
            }
        }
    }

    public function down(): void
    {
        // There's no going back...
    }
};

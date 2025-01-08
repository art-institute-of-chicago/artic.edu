<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;

return new class () extends Migration {
    public function up(): void
    {
        // Find all image blocks of digitalPublicationArticles
        $digiPubImageBlocks = Block::where('type', 'image')
            ->where('blockable_type', 'digitalPublicationArticles')
            ->get();

        // Update the content JSON column for image block on digital publication articles
        foreach ($digiPubImageBlocks as $block) {
            $content = $block->content;
            $content['size'] = 'l';
            $content['use_alt_background'] = true;
            $content['use_contain'] = true;

            // Update the block with the new JSON
            $block->content = $content;
            $block->save();
        }
    }

    public function down(): void
    {
        // There's no going back...
    }
};

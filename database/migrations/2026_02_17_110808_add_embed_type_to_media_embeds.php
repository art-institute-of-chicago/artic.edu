<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Vendor\Block;

return new class extends Migration
{
    public function up(): void
    {
        $blocks = Block::where('type', 'media_embed')->get();

        foreach ($blocks as $block) {
            if (empty($block['content']['embed_type'])) {
                $content = $block['content'];
                $content['embed_type'] = 'html';

                $block['content'] = $content;
                $block->save();
            }
        }
    }

    public function down(): void
    {
        // Maybe next time
    }
};

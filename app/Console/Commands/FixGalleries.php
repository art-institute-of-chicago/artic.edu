<?php

namespace App\Console\Commands;

use App\Models\Vendor\Block;

use Illuminate\Console\Command;

class FixGalleries extends Command
{
    protected $signature = 'fix:galleries';

    protected $description = 'Fixes name of artworks block in database';

    public function handle()
    {
        $blocks = Block::where('child_key', 'gallery_new_item')
            ->where('content->gallery_item_type', 'artwork')
            ->get();

        foreach ($blocks as $block) {
            $content = $block->content;
            if (isset($content['browsers']['artwork'])) {
                $content['browsers']['artworks'] = $content['browsers']['artwork'];
                unset($content['browsers']['artwork']);
                $block->content = $content;
                $block->save();
            }
        }
    }
}

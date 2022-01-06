<?php

use Illuminate\Database\Migrations\Migration;

class FixGalleryNewItemBrowser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $blocks = \App\Models\Vendor\Block::where('child_key', 'gallery_new_item')->where('content->gallery_item_type', 'artwork')->get();

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

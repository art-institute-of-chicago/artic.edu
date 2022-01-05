<?php

use Illuminate\Database\Migrations\Migration;

class MoveArtworksBlockToGalleryNewBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Move browser artworks in individual gallery_new_items
        $rows = DB::select('select * from blocks where type=?;', ['artworks']);
        foreach ($rows as $cols) {
            $content = json_decode($cols->content);

            // Insert new gallery_new_items
            if (isset($content->browsers)) {
                $artworkIds = $content->browsers->artworks;
                $i = 1;
                foreach ($artworkIds as $id) {
                    DB::table('blocks')->insert(
                        ['blockable_id' => $cols->blockable_id,
                            'blockable_type' => $cols->blockable_type,
                            'position' => $i++,
                            'content' => '{"gallery_item_type":"artwork","browsers":{"artworks":[' . $id . ']}}',
                            'type' => 'gallery_new_item',
                            'child_key' => 'gallery_new_item',
                            'parent_id' => $cols->id
                        ]
                    );
                }
                unset($content->browsers);
            }

            // Update block top gallery_new
            DB::update(
                'update blocks set '
                . 'content = ?, '
                . 'type = ? '
                . 'where id = ?',
                [json_encode($content),
                    'gallery_new',
                    $cols->id]
            );
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

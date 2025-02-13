<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Rename gallery_item blocks, and update JSON keys
        $rows = DB::select('select * from blocks where parent_id in (select id from blocks where type=?);', ['gallery']);

        foreach ($rows as $cols) {
            DB::update(
                'update blocks set '
                . 'type = ?, '
                . 'child_key = ? '
                . 'where id = ?',
                ['gallery_new_item',
                    'gallery_new_item',
                    $cols->id]
            );

            $newContent = str_replace('"caption"', '"captionText"', $cols->content);
            DB::update(
                'update blocks set '
                . 'content = ? '
                . 'where id = ?',
                [$newContent,
                    $cols->id]
            );
        }

        // Rename gallery blocks
        $rows = DB::select('select * from blocks where type=?;', ['gallery']);

        foreach ($rows as $cols) {
            DB::update(
                'update blocks set '
                . 'type = ? '
                . 'where id = ?',
                ['gallery_new',
                    $cols->id]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};

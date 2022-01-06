<?php

use Illuminate\Database\Migrations\Migration;

class RenameExtraSelectionMorphMapValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update(
            'update related set '
            . 'subject_type = ? '
            . 'where subject_type = ?',
            ['highlights',
                'selections']
        );

        DB::update(
            'update related set '
            . 'related_type = ? '
            . 'where related_type = ?',
            ['highlights',
                'selections']
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update(
            'update related set '
            . 'subject_type = ? '
            . 'where subject_type = ?',
            ['selections',
                'highlights']
        );

        DB::update(
            'update related set '
            . 'related_type = ? '
            . 'where related_type = ?',
            ['selections',
                'highlights']
        );
    }
}

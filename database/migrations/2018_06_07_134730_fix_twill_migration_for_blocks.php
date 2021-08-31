<?php

use Illuminate\Database\Migrations\Migration;

class FixTwillMigrationForBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("update mediables set mediable_type = 'blocks' where mediable_type = ?", ['A17\CmsToolkit\Models\Block']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("update mediables set mediable_type = 'A17\CmsToolkit\Models\Block' where mediable_type = ?", ['blocks']);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::update("update mediables set mediable_type = 'blocks' where mediable_type = ?", ['A17\CmsToolkit\Models\Block']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::update("update mediables set mediable_type = 'A17\CmsToolkit\Models\Block' where mediable_type = ?", ['blocks']);
    }
};

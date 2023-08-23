<?php

use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::table('related')->where('related_type', 'interactiveFeatures.experiences')->update(['related_type' => 'experiences']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('related')->where('related_type', 'experiences')->update(['related_type' => 'interactiveFeatures.experiences']);
    }
};

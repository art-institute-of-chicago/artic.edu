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
        DB::table('mediables')->where('mediable_type', 'interactiveFeatures.experiences')->update(['mediable_type' => 'experiences']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::table('mediables')->where('mediable_type', 'experiences')->update(['mediable_type' => 'interactiveFeatures.experiences']);
    }
};

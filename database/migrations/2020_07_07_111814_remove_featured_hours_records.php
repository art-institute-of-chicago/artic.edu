<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\FeaturedHour;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // No-op: moved to TranslationSeeder
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // No-op
    }
};

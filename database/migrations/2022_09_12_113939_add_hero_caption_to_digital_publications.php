<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->text('hero_caption')->nullable()->after('listing_description');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn('hero_caption');
        });
    }
};

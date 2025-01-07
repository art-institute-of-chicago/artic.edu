<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->string('listing_display')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('digital_publication_articles', function (Blueprint $table) {
            $table->dropColumn('listing_display');
        });
    }
};

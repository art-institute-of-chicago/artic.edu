<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('thumbnail_height')->nullable()->after('thumbnail_url');
            $table->integer('thumbnail_width')->nullable()->after('thumbnail_height');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->integer('thumbnail_height')->nullable()->after('thumbnail_url');
            $table->integer('thumbnail_width')->nullable()->after('thumbnail_height');
        });
    }

    public function down(): void
    {
        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_height', 'thumbnail_width']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_height', 'thumbnail_width']);
        });
    }
};

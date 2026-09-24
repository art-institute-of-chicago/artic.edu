<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->index('youtube_id', 'videos_youtube_index');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->index('youtube_id', 'playlists_youtube_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex('videos_youtube_index');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->dropIndex('playlists_youtube_index');
        });
    }
};

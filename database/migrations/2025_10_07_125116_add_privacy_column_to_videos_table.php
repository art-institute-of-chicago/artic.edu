<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->enum('privacy', ['private', 'public', 'unlisted'])->default('private');
        });
        Schema::table('playlist_video', function (Blueprint $table) {
            $table->dropUnique('playlist_video_youtube_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('playlist_video', function (Blueprint $table) {
            $table->unique('youtube_id');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('privacy');
        });
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('slides', function (Blueprint $table) {
            $table->string('video_play_settings')->nullable();
            $table->string('video_playback')->nullable();
            $table->string('youtube_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn(['video_play_settings', 'video_playback', 'youtube_url']);
        });
    }
};

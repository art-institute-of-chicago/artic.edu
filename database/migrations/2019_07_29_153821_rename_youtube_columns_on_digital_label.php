<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameYoutubeColumnsOnDigitalLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('experience_images', function (Blueprint $table) {
            $table->renameColumn('youtube_url', 'video_url');
        });

        Schema::table('experience_modals', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->renameColumn('youtube_url', 'video_url');
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->renameColumn('youtube_url', 'video_url');
            $table->renameColumn('split_youtube_url', 'split_video_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

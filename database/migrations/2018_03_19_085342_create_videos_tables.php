<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosTables extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('video_url')->nullable();
            $table->string('title');
            $table->dateTime('date')->nullable();
            $table->text('heading')->nullable();
        });

        Schema::create('video_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'video');
        });

        Schema::create('video_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'video');
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_revisions');
        Schema::dropIfExists('video_slugs');
        Schema::dropIfExists('videos');
    }
}

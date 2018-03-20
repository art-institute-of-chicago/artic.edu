<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVideosTables extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            createDefaultTableFields($table);
            // add some fields
            // use this one with the HasPosition trait
            // $table->integer('position')->unsigned()->nullable();
            $table->string('video_url')->nullable();
            $table->string('title');
            $table->dateTime('date')->nullable();
            $table->text('heading')->nullable();
        });


        // remove this if you're not going to use slugs
        Schema::create('video_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'video');
        });

        // remove this if you're not going to use revisions
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

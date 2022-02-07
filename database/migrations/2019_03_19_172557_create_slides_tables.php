<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidesTables extends Migration
{
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->string('asset_type')->default('standard');
            $table->string('module_type')->default('split');
            $table->string('media_type')->default('type_image');
            $table->string('media_title')->nullable();
            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('CASCADE');
        });

        Schema::create('slide_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'slide');
        });

        Schema::create('slide_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'slide');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slide_revisions');
        Schema::dropIfExists('slide_translations');
        Schema::dropIfExists('slide_slugs');
        Schema::dropIfExists('slides');
    }
}

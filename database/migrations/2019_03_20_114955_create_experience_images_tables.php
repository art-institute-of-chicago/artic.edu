<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperienceImagesTables extends Migration
{
    public function up()
    {
        Schema::create('experience_images', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title', 200)->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('inline_credits')->default('off');
            $table->string('credits_input')->default('datahub');
            $table->string('object_id')->nullable();
            $table->string('artist')->nullable();
            $table->string('credit_title')->nullable();
            $table->string('credit_date')->nullable();
            $table->string('medium')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('credit_line')->nullable();
            $table->string('main_reference_number')->nullable();
            $table->string('copyright_notice')->nullable();
            $table->string('imagable_type')->nullable();
            $table->integer('imagable_id')->unsigned();
            $table->string('imagable_repeater_name')->nullable();
            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('experience_image_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'experience_image');
        });

        Schema::create('experience_image_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'experience_image');
        });
    }

    public function down()
    {
        Schema::dropIfExists('experience_image_revisions');
        Schema::dropIfExists('experience_image_translations');
        Schema::dropIfExists('experience_image_slugs');
        Schema::dropIfExists('experience_images');
    }
}

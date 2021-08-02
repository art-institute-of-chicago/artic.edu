<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperienceModalsTables extends Migration
{
    public function up()
    {
        Schema::create('experience_modals', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('modal_type')->nullable();
            $table->boolean('zoomable')->default(false);
            $table->string('video_play_settings')->nullable();
            $table->string('video_playback')->nullable();
            $table->string('image_sequence_playback')->nullable();
            $table->string('image_sequence_caption')->nullable();
            $table->string('modalble_type')->nullable();
            $table->integer('modalble_id')->unsigned();
            $table->string('modalble_repeater_name')->nullable();
            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('experience_modal_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'experience_modal');
        });

        Schema::create('experience_modal_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'experience_modal');
        });
    }

    public function down()
    {
        Schema::dropIfExists('experience_modal_revisions');
        Schema::dropIfExists('experience_modal_slugs');
        Schema::dropIfExists('experience_modals');
    }
}

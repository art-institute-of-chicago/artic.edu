<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperienceModalsTables extends Migration
{
    public function up()
    {
        Schema::create('experience_modals', function (Blueprint $table) {

            // this will create an id, a "published" column, and soft delete and timestamps columns
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

            // add those 2 colums to enable publication timeframe fields (you can use publish_start_date only if you don't need to provide the ability to specify an end date)
            // $table->timestamp('publish_start_date')->nullable();
            // $table->timestamp('publish_end_date')->nullable();

            // use this column with the HasPosition trait
            $table->integer('position')->unsigned()->nullable();
        });

        // remove this if you're not going to use any translated field, ie. using the HasTranslation trait. If you do use it, create fields you want translatable in this table instead of the main table above. You do not need to create fields in both tables.
        // Schema::create('experience_modal_translations', function (Blueprint $table) {
        //     createDefaultTranslationsTableFields($table, 'experience_modal');
        //     // add some translated fields
        //     // $table->string('title', 200)->nullable();
        //     // $table->text('description')->nullable();
        // });

        // remove this if you're not going to use slugs, ie. using the HasSlug trait
        Schema::create('experience_modal_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'experience_modal');
        });

        // remove this if you're not going to use revisions, ie. using the HasRevisions trait
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

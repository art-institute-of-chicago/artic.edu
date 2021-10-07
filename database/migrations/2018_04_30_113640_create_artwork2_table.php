<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtwork2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('datahub_id');
        });

        Schema::create('article_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artwork');
            $table->integer('position')->unsigned()->index();
        });

        Schema::create('artwork_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'artwork', 'video');
            $table->integer('position')->unsigned()->index();
        });

        Schema::create('artwork_event', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'artwork', 'event');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artwork_event');
        Schema::dropIfExists('artwork_video');
        Schema::dropIfExists('article_artwork');
        Schema::dropIfExists('artwork_exhibition');
        Schema::dropIfExists('artworks');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteArtworkRelatedTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('artwork_exhibition');
        Schema::dropIfExists('article_artwork');
        Schema::dropIfExists('artwork_slugs');
        Schema::dropIfExists('artworks');
    }

    public function down()
    {
        Schema::create('artwork_exhibition', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'artwork', 'exhibition');
            $table->integer('position')->unsigned()->index();
        });
        Schema::create('article_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artwork');
            $table->integer('position')->unsigned()->index();
        });
        Schema::create('artworks', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('copy')->nullable();
            $table->string('datahub_id');
        });

        // remove this if you're not going to use slugs
        Schema::create('artwork_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'artwork');
        });
    }
}

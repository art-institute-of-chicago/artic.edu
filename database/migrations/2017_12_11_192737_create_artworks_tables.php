<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtworksTables extends Migration
{
    public function up()
    {
        Schema::create('artworks', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('copy')->nullable();
            $table->string('datahub_id');
        });

        Schema::create('artwork_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'artwork');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artwork_slugs');
        Schema::dropIfExists('artworks');
    }
}

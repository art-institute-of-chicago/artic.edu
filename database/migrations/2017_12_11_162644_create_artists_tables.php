<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArtistsTables extends Migration
{
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->text('biography')->nullable();
            $table->string('name');
            $table->string('datahub_id');
        });

        Schema::create('artist_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'artist');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artist_slugs');

        Schema::dropIfExists('artists');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtworkExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artwork_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->integer("artwork_id")->unsigned();
            $table->foreign("artwork_id")->references('id')->on('artworks')->onDelete('cascade');
            $table->index(["artwork_id", "experience_id"], 'artwork_experience_artwork_id_experience_id_idx');

            $table->integer('position')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artwork_experience');
    }
}

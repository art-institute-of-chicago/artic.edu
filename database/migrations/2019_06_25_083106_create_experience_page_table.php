<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperiencePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experience_page', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->index(['page_id', 'experience_id'], 'experience_page_page_id_experience_id_idx');

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
        Schema::dropIfExists('experience_page');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeamlessImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seamless_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->unsignedInteger('zip_file_id');
            $table->foreign('zip_file_id')
                ->references('id')->on('files')
                ->onDelete('cascade');
            $table->integer('frame');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seamless_images');
    }
}

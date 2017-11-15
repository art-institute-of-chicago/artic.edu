<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategorySegmentsTables extends Migration
{
    public function up()
    {
        Schema::create('category_segments', function (Blueprint $table) {
            createDefaultTableFields($table);

            // add some fields

            // use a json field to store block editor fields
            // $table->json('content')->nullable();

            // use this with the HasPosition trait
            $table->string('title');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_segments');
    }
}

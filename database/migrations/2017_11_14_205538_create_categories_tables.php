<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title');

            // use a json field to store block editor fields
            // $table->json('content')->nullable();

            // use this with the HasPosition trait
            // $table->integer('position')->unsigned()->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'category');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_slugs');

        Schema::dropIfExists('categories');
    }
}

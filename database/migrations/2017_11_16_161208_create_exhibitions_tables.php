<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExhibitionsTables extends Migration
{
    public function up()
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            createDefaultTableFields($table);

            // Add default detail fields
            createDefaultDetailTableFields($table);

            // use a json field to store block editor fields
            $table->json('content')->nullable();

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
        });

        // remove this if you're not going to use slugs
        Schema::create('exhibition_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'exhibition');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exhibition_slugs');
        Schema::dropIfExists('exhibitions');
    }
}

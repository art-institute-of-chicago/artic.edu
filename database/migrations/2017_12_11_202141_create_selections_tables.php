<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSelectionsTables extends Migration
{
    public function up()
    {
        Schema::create('selections', function (Blueprint $table) {
            createDefaultTableFields($table);

            // Use a json field to store block editor fields
            $table->json('content')->nullable();

            $table->string('title');
            $table->text('short_copy');
        });

        Schema::create('selection_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'selection');
        });

        Schema::create('artwork_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'artwork', 'selection');
            $table->integer('position')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('artwork_selection');

        Schema::dropIfExists('selection_slugs');

        Schema::dropIfExists('selections');
    }
}

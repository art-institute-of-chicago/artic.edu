<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVirtualToursTables extends Migration
{
    public function up()
    {
        Schema::create('virtual_tours', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('video_url')->nullable();
            $table->string('title');
            $table->dateTime('date')->nullable();
            $table->text('heading')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->text('title_display')->nullable()->after('title');
            $table->text('list_description')->nullable()->after('heading');
        });

        Schema::create('virtual_tour_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'virtual_tour');
        });

        Schema::create('virtual_tour_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'virtual_tour');
        });
    }

    public function down()
    {
        Schema::dropIfExists('virtual_tour_revisions');
        Schema::dropIfExists('virtual_tour_slugs');
        Schema::dropIfExists('virtual_tours');
    }
}

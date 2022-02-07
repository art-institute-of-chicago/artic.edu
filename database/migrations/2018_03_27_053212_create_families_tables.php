<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFamiliesTables extends Migration
{
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
            $table->string('external_link')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('CASCADE');
        });

        Schema::create('family_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'family');
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_revisions');
        Schema::dropIfExists('families');
    }
}

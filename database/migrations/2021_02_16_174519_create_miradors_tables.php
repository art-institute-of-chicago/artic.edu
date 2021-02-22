<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMiradorsTables extends Migration
{
    public function up()
    {
        Schema::create('miradors', function (Blueprint $table) {

            // this will create an id, a "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->string('title');
            $table->dateTime('date')->nullable();
            $table->text('heading')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->text('title_display')->nullable()->after('title');
            $table->text('list_description')->nullable()->after('heading');
        });

        // remove this if you're not going to use slugs, ie. using the HasSlug trait
        Schema::create('mirador_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'mirador');
        });

        // remove this if you're not going to use revisions, ie. using the HasRevisions trait
        Schema::create('mirador_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'mirador');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mirador_revisions');
        Schema::dropIfExists('mirador_slugs');
        Schema::dropIfExists('miradors');
    }
}

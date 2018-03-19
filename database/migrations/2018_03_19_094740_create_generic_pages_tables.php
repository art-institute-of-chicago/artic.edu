<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenericPagesTables extends Migration
{
    public function up()
    {
        Schema::create('generic_pages', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
            // add some fields
            // use this one with the HasPosition trait
            $table->integer('position')->unsigned()->nullable();
            $table->nestedSet();
        });

        // remove this if you're not going to use any translated field
        // Schema::create('generic_page_translations', function (Blueprint $table) {
        //     createDefaultTranslationsTableFields($table, 'generic_page');
        //     // add some translated fields
        //     // $table->string('title', 200)->nullable();
        //     // $table->text('description')->nullable();
        // });

        // remove this if you're not going to use slugs
        Schema::create('generic_page_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'generic_page');
        });

        // remove this if you're not going to use revisions
        Schema::create('generic_page_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'generic_page');
        });
    }

    public function down()
    {
        Schema::dropIfExists('generic_page_revisions');
        // Schema::dropIfExists('generic_page_translations');
        Schema::dropIfExists('generic_page_slugs');
        Schema::dropIfExists('generic_pages');
    }
}

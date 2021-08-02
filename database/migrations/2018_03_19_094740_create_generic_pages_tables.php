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
            $table->integer('position')->unsigned()->nullable();
            $table->nestedSet();
        });

        Schema::create('generic_page_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'generic_page');
        });

        Schema::create('generic_page_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'generic_page');
        });
    }

    public function down()
    {
        Schema::dropIfExists('generic_page_revisions');
        Schema::dropIfExists('generic_page_slugs');
        Schema::dropIfExists('generic_pages');
    }
}

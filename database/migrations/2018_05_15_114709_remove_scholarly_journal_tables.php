<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveScholarlyJournalTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('scholarly_journal_slugs');
        Schema::dropIfExists('scholarly_journal_revisions');
        Schema::dropIfExists('page_scholarly_journal');
        Schema::dropIfExists('scholarly_journals');
    }

    public function down()
    {
        Schema::create('scholarly_journals', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        Schema::create('scholarly_journal_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'scholarly_journal');
        });

        Schema::create('scholarly_journal_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'scholarly_journal');
        });

        Schema::create('page_scholarly_journal', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'scholarly_journal');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }
}

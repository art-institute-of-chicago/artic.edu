<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScholarlyJournalsTables extends Migration
{
    public function up()
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
    }

    public function down()
    {
        Schema::dropIfExists('scholarly_journal_revisions');
        Schema::dropIfExists('scholarly_journal_slugs');
        Schema::dropIfExists('scholarly_journals');
    }
}

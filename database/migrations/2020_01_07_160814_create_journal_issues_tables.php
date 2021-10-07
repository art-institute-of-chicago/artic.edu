<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJournalIssuesTables extends Migration
{
    public function up()
    {
        Schema::create('journal_issues', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->text('title')->nullable();
            $table->text('title_display')->nullable();
            $table->text('description')->nullable();
            $table->text('list_description')->nullable();
            $table->dateTime('date')->nullable();
            $table->integer('issue_number')->unsigned()->nullable();
            $table->text('license_text')->nullable();
            $table->timestamp('publish_start_date')->nullable();

            $table->integer('position')->unsigned()->nullable();
        });


        Schema::create('journal_issue_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'journal_issue');
        });

        Schema::create('journal_issue_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'journal_issue');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_issue_revisions');
        Schema::dropIfExists('journal_issue_slugs');
        Schema::dropIfExists('journal_issues');
    }
}

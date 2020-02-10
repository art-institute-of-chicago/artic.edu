<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropJournalTablesNoLongerUsed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('journal_article_revisions');
        Schema::dropIfExists('journal_article_slugs');
        Schema::dropIfExists('journal_articles');

        Schema::dropIfExists('journal_issue_revisions');
        Schema::dropIfExists('journal_issue_slugs');
        Schema::dropIfExists('journal_issues');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     * @see CreateJournalIssuesTables::up();
     * @see CreateJournalArticlesTables::up();
     */
    public function down()
    {
        Schema::create('journal_articles', function (Blueprint $table) {
            createDefaultTableFields($table);
        });

        Schema::create('journal_article_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'journal_article');
        });

        Schema::create('journal_article_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'journal_article');
        });

        Schema::create('journal_issues', function (Blueprint $table) {
            createDefaultTableFields($table);
        });

        Schema::create('journal_issue_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'journal_issue');
        });

        Schema::create('journal_issue_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'journal_issue');
        });
    }
}

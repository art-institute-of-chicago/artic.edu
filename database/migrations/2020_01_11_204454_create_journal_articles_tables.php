<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJournalArticlesTables extends Migration
{
    public function up()
    {
        Schema::create('journal_articles', function (Blueprint $table) {

            createDefaultTableFields($table);

            $table->text('title')->nullable();
            $table->text('title_display')->nullable();
            $table->text('short_title_display')->nullable();
            $table->text('description')->nullable();
            $table->text('list_description')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('type')->nullable();
            $table->text('abstract')->nullable();
            $table->text('author_display')->nullable();
            $table->string('review_status')->nullable();
            $table->text('license_text')->nullable();
            $table->timestamp('publish_start_date')->nullable();
            $table->integer('journal_issue_id')->unsigned()->nullable();
            $table->foreign('journal_issue_id')->references('id')->on('journal_issues')->onDelete('cascade');

            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('journal_article_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'journal_article');
        });

        Schema::create('journal_article_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'journal_article');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_article_revisions');
        Schema::dropIfExists('journal_article_slugs');
        Schema::dropIfExists('journal_articles');
    }
}

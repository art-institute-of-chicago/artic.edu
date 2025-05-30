<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('issue_articles', function (Blueprint $table) {
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
            $table->integer('issue_id')->unsigned()->nullable();
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

            $table->integer('position')->unsigned()->nullable();
        });

        Schema::create('issue_article_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'issue_article');
        });

        Schema::create('issue_article_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'issue_article');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issue_article_revisions');
        Schema::dropIfExists('issue_article_slugs');
        Schema::dropIfExists('issue_articles');
    }
};

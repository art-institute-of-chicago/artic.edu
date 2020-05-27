<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMagazineIssuesTables extends Migration
{
    public function up()
    {
        Schema::create('magazine_issues', function (Blueprint $table) {
            // id, "published" column, and soft delete and timestamps columns
            createDefaultTableFields($table);

            $table->text('title')->nullable();
            $table->text('list_description')->nullable();
            $table->timestamp('publish_start_date')->nullable();

        });

        // remove this if you're not going to use slugs, ie. using the HasSlug trait
        Schema::create('magazine_issue_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'magazine_issue');
        });

        // remove this if you're not going to use revisions, ie. using the HasRevisions trait
        Schema::create('magazine_issue_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'magazine_issue');
        });
    }

    public function down()
    {
        Schema::dropIfExists('magazine_issue_revisions');
        Schema::dropIfExists('magazine_issue_slugs');
        Schema::dropIfExists('magazine_issues');
    }
}

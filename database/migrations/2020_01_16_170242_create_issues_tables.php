<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesTables extends Migration
{
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
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

        Schema::create('issue_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'issue');
        });

        Schema::create('issue_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'issue');
        });
    }

    public function down()
    {
        Schema::dropIfExists('issue_revisions');
        Schema::dropIfExists('issue_slugs');
        Schema::dropIfExists('issues');
    }
}

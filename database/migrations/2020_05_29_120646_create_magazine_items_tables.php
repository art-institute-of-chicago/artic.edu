<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMagazineItemsTables extends Migration
{
    public function up()
    {
        Schema::create('magazine_items', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->text('title', 200)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('publish_start_date')->nullable();
            $table->integer('position')->unsigned()->nullable();
            $table->string('feature_type');
            $table->string('tag')->nullable();
            $table->string('call_to_action')->nullable();
            $table->text('url')->nullable();

            $table->integer('magazine_issue_id')->unsigned()->nullable();
            $table->foreign('magazine_issue_id')->references('id')->on('magazine_issues')->onDelete('cascade');
        });

        Schema::create('magazine_item_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'magazine_item');
        });
    }

    public function down()
    {
        Schema::dropIfExists('magazine_item_revisions');
        Schema::dropIfExists('magazine_items');
    }
}

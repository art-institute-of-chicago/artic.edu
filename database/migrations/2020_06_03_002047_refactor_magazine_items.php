<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorMagazineItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('magazine_item_revisions');
        Schema::dropIfExists('magazine_items');

        Schema::create('magazine_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('magazine_issue_id')->unsigned()->nullable();
            $table->foreign('magazine_issue_id')->references('id')->on('magazine_issues')->onDelete('cascade');

            // Fields for the non-"Custom" types
            $table->integer('magazinable_id')->unsigned()->nullable();
            $table->string('magazinable_type')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->string('feature_type')->nullable(); // integer bugs out connected_fields!

            // Fields for "Custom" type
            $table->string('tag')->nullable();
            $table->text('title')->nullable();
            $table->text('list_description')->nullable();
            $table->text('url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_items');

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
}

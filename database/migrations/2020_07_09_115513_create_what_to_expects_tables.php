<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWhatToExpectsTables extends Migration
{
    public function up()
    {
        Schema::create('what_to_expects', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->integer('icon_type')->unsigned()->nullable();
            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned()->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

        Schema::create('what_to_expect_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'what_to_expect');
            $table->text('text')->nullable();
        });

        Schema::create('what_to_expect_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'what_to_expect');
        });
    }

    public function down()
    {
        Schema::dropIfExists('what_to_expect_revisions');
        Schema::dropIfExists('what_to_expect_translations');
        Schema::dropIfExists('what_to_expects');
    }
}

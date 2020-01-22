<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuthorsTables extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title')->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('author_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'author');
        });

        Schema::create('author_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'author');
        });
    }

    public function down()
    {
        Schema::dropIfExists('author_revisions');
        Schema::dropIfExists('author_slugs');
        Schema::dropIfExists('authors');
    }
}

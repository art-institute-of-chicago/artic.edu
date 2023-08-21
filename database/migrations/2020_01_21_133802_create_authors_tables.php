<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::dropIfExists('author_revisions');
        Schema::dropIfExists('author_slugs');
        Schema::dropIfExists('authors');
    }
};

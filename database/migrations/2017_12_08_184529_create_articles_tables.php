<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->json('content')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('title');
            $table->text('copy')->nullable();
        });

        Schema::create('article_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'article');
        });

        Schema::create('article_revisions', function (Blueprint $table) {
            createDefaultTableFields($table, false, false);
            $table->json('payload');
            $table->integer('article_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_revisions');
        Schema::dropIfExists('article_slugs');
        Schema::dropIfExists('articles');
    }
};

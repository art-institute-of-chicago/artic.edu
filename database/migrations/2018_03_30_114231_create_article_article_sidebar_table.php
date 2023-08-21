<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('article_article_sidebar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('related_article_id')->unsigned();
            $table->foreign('related_article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->index(['related_article_id', 'article_id']);

            $table->integer('position')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('article_article_sidebar');
    }
};

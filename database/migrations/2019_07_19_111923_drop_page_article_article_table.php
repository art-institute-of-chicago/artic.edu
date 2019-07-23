<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPageArticleArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('page_article_article');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('page_article_article', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'article');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }
}

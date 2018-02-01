<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageArtArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('page_art_article', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'article');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_art_article');
    }
}

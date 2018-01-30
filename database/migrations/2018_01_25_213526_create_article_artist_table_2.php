<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleArtistTable2 extends Migration
{
    public function up()
    {
        Schema::create('article_artist', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artist');
            $table->integer('position')->unsigned()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('article_artist');
    }
}

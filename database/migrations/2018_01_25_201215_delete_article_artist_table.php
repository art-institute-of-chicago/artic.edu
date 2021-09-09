<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteArticleArtistTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('article_artist');
    }

    public function down()
    {
        Schema::create('article_artist', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'artist');
            $table->integer('position')->unsigned()->index();
        });
    }
}

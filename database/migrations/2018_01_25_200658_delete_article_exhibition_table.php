<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteArticleExhibitionTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('article_exhibition');
    }

    public function down()
    {
        Schema::create('article_exhibition', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'exhibition');
            $table->integer('position')->unsigned()->index();
        });
    }
}

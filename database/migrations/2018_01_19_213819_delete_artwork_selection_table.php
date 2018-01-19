<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteArtworkSelectionTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('article_selection');
    }

    public function down()
    {
        Schema::create('article_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'article', 'selection');
            $table->integer('position')->unsigned()->index();
        });
    }
}

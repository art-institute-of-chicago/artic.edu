<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectionVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selection_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            createDefaultRelationshipTableFields($table, 'selection', 'video');
            $table->integer('position')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('selection_video');
    }
}

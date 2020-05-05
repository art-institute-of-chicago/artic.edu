<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUneededTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('page_home_video');
        Schema::dropIfExists('page_home_selection');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('page_home_video', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'video');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });

        Schema::create('page_home_selection', function (Blueprint $table) {
            $table->increments('id');

            createDefaultRelationshipTableFields($table, 'page', 'selection');
            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }
}

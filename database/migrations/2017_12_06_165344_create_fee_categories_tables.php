<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeeCategoriesTables extends Migration
{
    public function up()
    {
        Schema::create('fee_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);

            // use this with the HasPosition trait
            $table->integer('position')->unsigned()->nullable();
            $table->string('title');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fee_categories');
    }
}

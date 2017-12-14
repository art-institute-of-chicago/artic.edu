<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('name')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign("page_id")->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}

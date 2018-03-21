<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeaturedHoursTables extends Migration
{
    public function up()
    {
        Schema::create('featured_hours', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('title')->nullable();
            $table->string('external_link')->nullable();
            $table->text('copy')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign("page_id")->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('featured_hours');
    }
}

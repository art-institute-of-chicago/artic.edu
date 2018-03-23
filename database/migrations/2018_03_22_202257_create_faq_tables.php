<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqTables extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            createDefaultTableFields($table);
            // add some fields
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign("page_id")->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}

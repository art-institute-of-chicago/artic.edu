<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdmissionsTables extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            createDefaultTableFields($table);

            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->text('copy')->nullable();

            $table->integer('position')->unsigned()->nullable();

            $table->integer('page_id')->unsigned();
            $table->foreign("page_id")->references('id')->on('pages')->onDelete('CASCADE');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}

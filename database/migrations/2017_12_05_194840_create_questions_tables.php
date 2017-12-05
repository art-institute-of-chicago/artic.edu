<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTables extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            createDefaultTableFields($table);

            // use this with the HasPosition trait
            $table->integer('position')->unsigned()->nullable();

            $table->text('question');
            $table->text('answer');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClosuresTables extends Migration
{
    public function up()
    {
        Schema::create('closures', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->date('date_start');
            $table->date('date_end');
            $table->string('closure_copy')->nullable();
            $table->integer('type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('closures');
    }
}

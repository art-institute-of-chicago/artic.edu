<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSponsorsTables extends Migration
{
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->string('title');
            $table->text('copy');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sponsors');
    }
}

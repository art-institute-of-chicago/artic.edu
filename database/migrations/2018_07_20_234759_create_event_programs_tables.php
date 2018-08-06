<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventProgramsTables extends Migration
{
    public function up()
    {
        Schema::create('event_programs', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_programs');
    }
}

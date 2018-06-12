<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTicketedEventsTables extends Migration
{
    public function up()
    {
        Schema::create('ticketed_events', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->integer('datahub_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('resource_id')->nullable();
            $table->string('resource_title')->nullable();
            $table->integer('available')->nullable();
            $table->integer('total_capacity')->nullable();
        });

    }

    public function down()
    {
        Schema::dropIfExists('ticketed_events');
    }
}

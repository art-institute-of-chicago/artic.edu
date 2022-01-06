<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteEventEventTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('event_event');
    }


    public function down()
    {
        Schema::create('event_event', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('event_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->integer('related_event_id')->unsigned();
            $table->foreign('related_event_id')->references('id')->on('events')->onDelete('cascade');
            $table->index(['related_event_id', 'event_id']);

            $table->integer('position')->unsigned()->index();

            $table->timestamps();
        });
    }
}

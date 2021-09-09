<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTables extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            createDefaultTableFields($table);

            // Use a json field to store block editor fields
            $table->json('content')->nullable();

            $table->string('title');
            $table->double('price', 8, 2)->nullable();
            $table->string('datahub_id')->nullable();
            $table->string('admission')->nullable();
            $table->boolean('recurring');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('recurring_start_date')->nullable();
            $table->dateTime('recurring_end_date')->nullable();
            $table->string('recurring_days')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });

        Schema::create('event_revisions', function (Blueprint $table) {
            createDefaultTableFields($table, false, false);
            $table->json('payload');
            $table->integer('event_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('event_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'event');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_slugs');
        Schema::dropIfExists('event_revisions');
        Schema::dropIfExists('events');
    }
}

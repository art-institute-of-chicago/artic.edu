<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateEventMetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropifExists('event_metas');

        Schema::create('event_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date_end')->nullable();
            $table->datetime('date')->nullable();
            $table->integer('event_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('event_metas', function (Blueprint $table) {
            $table->datetime('date_end')->nullable();
            $table->datetime('date')->nullable();
            $table->integer('event_id')->index();
            $table->timestamps();
        });
    }
}

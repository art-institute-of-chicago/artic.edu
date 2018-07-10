<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEventEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_event', function (Blueprint $table) {
            $table->dropForeign("event_event_related_event_id_foreign");
            $table->dropIndex("event_event_related_event_id_event_id_index");
            $table->dropColumn("related_event_id")->unsigned();
            $table->integer("datahub_id")->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_event', function (Blueprint $table) {
            $table->dropColumn("datahub_id");
            $table->integer("related_event_id")->unsigned();
            $table->foreign("related_event_id")->references('id')->on('events')->onDelete('cascade');
            $table->index(["related_event_id", "event_id"]);
        });
    }
}

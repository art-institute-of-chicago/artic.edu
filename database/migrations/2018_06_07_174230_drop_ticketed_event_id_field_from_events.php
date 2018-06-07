<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTicketedEventIdFieldFromEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('ticketed_event_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('events', function (Blueprint $table) {
            $table->integer('ticketed_event_id')->unsigned()->nullable()->after('is_admission_required');
            $table->foreign("ticketed_event_id")->references('id')->on('ticketed_events')->onDelete('CASCADE');
        });

    }
}

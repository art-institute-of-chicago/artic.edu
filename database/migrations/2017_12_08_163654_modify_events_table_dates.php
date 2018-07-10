<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEventsTableDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['recurring_start_date', 'recurring_end_date']);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->string('recurring_start_time')->nullable();
            $table->string('recurring_end_time')->nullable();
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
            $table->dateTime('recurring_start_date')->nullable();
            $table->dateTime('recurring_end_date')->nullable();
            $table->dropColumn('recurring_start_time');
            $table->dropColumn('recurring_end_time');
        });
    }
}

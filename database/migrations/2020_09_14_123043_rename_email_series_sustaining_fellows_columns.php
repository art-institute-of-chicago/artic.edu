<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmailSeriesSustainingFellowsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->renameColumn('show_sustaining_fellow', 'show_luminary');
            $table->renameColumn('show_sustaining_fellow_test', 'show_luminary_test');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('sustaining_fellow_copy', 'luminary_copy');
            $table->renameColumn('send_sustaining_fellow_test', 'send_luminary_test');
            $table->renameColumn('override_sustaining_fellow', 'override_luminary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->renameColumn('show_luminary', 'show_sustaining_fellow');
            $table->renameColumn('show_luminary_test', 'show_sustaining_fellow_test');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('luminary_copy', 'sustaining_fellow_copy');
            $table->renameColumn('send_luminary_test', 'send_sustaining_fellow_test');
            $table->renameColumn('override_luminary', 'override_sustaining_fellow');
        });
    }
}

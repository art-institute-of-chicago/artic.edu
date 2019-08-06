<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSendFieldsToOverrideOnEventEmailSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_affiliate', 'override_affiliate');
            $table->renameColumn('send_member', 'override_member');
            $table->renameColumn('send_sustaining_fellow', 'override_sustaining_fellow');
            $table->renameColumn('send_nonmember', 'override_nonmember');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('override_affiliate', 'send_affiliate');
            $table->renameColumn('override_member', 'send_member');
            $table->renameColumn('override_sustaining_fellow', 'send_sustaining_fellow');
            $table->renameColumn('override_nonmember', 'send_nonmember');
        });
    }
}

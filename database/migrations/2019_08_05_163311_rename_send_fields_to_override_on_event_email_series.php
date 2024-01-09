<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_affiliate', 'override_affiliate');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_member', 'override_member');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_sustaining_fellow', 'override_sustaining_fellow');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_nonmember', 'override_nonmember');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('override_affiliate', 'send_affiliate');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('override_member', 'send_member');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('override_sustaining_fellow', 'send_sustaining_fellow');
        });
        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('override_nonmember', 'send_nonmember');
        });
    }
};

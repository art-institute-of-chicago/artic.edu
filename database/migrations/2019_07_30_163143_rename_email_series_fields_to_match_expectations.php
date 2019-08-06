<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmailSeriesFieldsToMatchExpectations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->renameColumn('show_affiliate_member', 'show_affiliate');
            $table->renameColumn('affiliate_member_copy', 'affiliate_copy');
            $table->renameColumn('show_non_member', 'show_nonmember');
            $table->renameColumn('non_member_copy', 'nonmember_copy');
        });

        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_affiliate_member', 'send_affiliate');
            $table->renameColumn('affiliate_member_copy', 'affiliate_copy');
            $table->renameColumn('send_non_member', 'send_nonmember');
            $table->renameColumn('non_member_copy', 'nonmember_copy');
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
            $table->renameColumn('show_affiliate', 'show_affiliate_member');
            $table->renameColumn('affiliate_copy', 'affiliate_member_copy');
            $table->renameColumn('show_nonmember', 'show_non_member');
            $table->renameColumn('nonmember_copy', 'non_member_copy');
        });

        Schema::table('event_email_series', function (Blueprint $table) {
            $table->renameColumn('send_affiliate', 'send_affiliate_member');
            $table->renameColumn('affiliate_copy', 'affiliate_member_copy');
            $table->renameColumn('send_nonmember', 'send_non_member');
            $table->renameColumn('nonmember_copy', 'non_member_copy');
        });
    }
}

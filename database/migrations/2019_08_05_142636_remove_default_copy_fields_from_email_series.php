<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDefaultCopyFieldsFromEmailSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->dropColumn([
                'affiliate_copy',
                'member_copy',
                'sustaining_fellow_copy',
                'nonmember_copy',
            ]);
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
            $table->text('affiliate_copy')->nullable()->after('show_affiliate');
            $table->text('member_copy')->nullable()->after('show_member');
            $table->text('sustaining_fellow_copy')->nullable()->after('show_sustaining_fellow');
            $table->text('nonmember_copy')->nullable()->after('show_nonmember');
        });
    }
}

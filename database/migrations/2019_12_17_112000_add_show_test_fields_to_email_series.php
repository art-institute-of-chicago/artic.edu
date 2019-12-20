<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowTestFieldsToEmailSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->boolean('show_affiliate_test')->default(false)->after('show_nonmember');
            $table->boolean('show_member_test')->default(false)->after('show_affiliate_test');
            $table->boolean('show_sustaining_fellow_test')->default(false)->after('show_member_test');
            $table->boolean('show_nonmember_test')->default(false)->after('show_sustaining_fellow_test');
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
            $table->dropColumn([
                'show_affiliate_test',
                'show_member_test',
                'show_sustaining_fellow_test',
                'show_nonmember_test',
            ]);
        });
    }
}

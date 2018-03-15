<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreMembershipFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            // Exhibition History
            $table->string('home_membership_module_headline')->nullable();
            $table->string('home_membership_module_short_copy')->nullable();
            $table->string('home_membership_module_button_text')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_membership_module_headline');
            $table->dropColumn('home_membership_module_short_copy');
            $table->dropColumn('home_membership_module_button_text');
        });
    }
}

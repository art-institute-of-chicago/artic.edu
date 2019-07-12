<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAffiliateGroupToEventPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_programs', function (Blueprint $table) {
            $table->boolean('is_affiliate_group')->default(false)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_programs', function (Blueprint $table) {
            $table->dropColumn('is_affiliate_group');
        });
    }
}

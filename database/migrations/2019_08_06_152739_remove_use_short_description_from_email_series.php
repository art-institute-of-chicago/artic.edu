<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUseShortDescriptionFromEmailSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_series', function (Blueprint $table) {
            $table->dropColumn('use_short_description');
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
            $table->boolean('use_short_description')->default(false)->after('show_nonmember');
        });
    }
}

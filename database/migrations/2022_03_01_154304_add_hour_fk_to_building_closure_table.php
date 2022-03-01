<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHourFkToBuildingClosureTable extends Migration
{
    public function up()
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->integer('hour_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->dropColumn('hour_id');
        });
    }
}

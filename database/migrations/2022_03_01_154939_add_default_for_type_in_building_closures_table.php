<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultForTypeInBuildingClosuresTable extends Migration
{
    public function up()
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->integer('type')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('building_closures', function (Blueprint $table) {
            $table->integer('type')->default(null)->change();
        });
    }
}

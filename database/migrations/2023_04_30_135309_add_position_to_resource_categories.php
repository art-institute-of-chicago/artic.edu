<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddPositionToResourceCategories extends Migration
{
    public function up()
    {
        Schema::table('resource_categories', function (Blueprint $table) {
            $table->integer('position')->nullable();
        });
    }

    public function down()
    {
        Schema::table('resource_categories', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
}

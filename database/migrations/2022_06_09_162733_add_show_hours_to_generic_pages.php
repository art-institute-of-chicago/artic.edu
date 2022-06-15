<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowHoursToGenericPages extends Migration
{
    public function up()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->boolean('show_hours')->default(false);
        });
    }

    public function down()
    {
        Schema::table('generic_pages', function (Blueprint $table) {
            $table->dropColumn('show_hours');
        });
    }
}

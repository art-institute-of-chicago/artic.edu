<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNestedSetToLandingPages extends Migration
{
    public function up()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->nestedSet();
        });
    }

    public function down()
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropNestedSet();
        });
    }
}

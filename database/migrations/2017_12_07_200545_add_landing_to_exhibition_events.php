<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLandingToExhibitionEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->boolean('landing')->default(true)->index();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('landing')->default(true)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('landing');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('landing');
        });
    }
}

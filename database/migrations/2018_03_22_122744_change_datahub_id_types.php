<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDatahubIdTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->string('datahub_id');
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('datahub_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('datahub_id');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->integer('datahub_id')->unsigned();
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->integer('datahub_id')->unsigned();
        });
    }
}

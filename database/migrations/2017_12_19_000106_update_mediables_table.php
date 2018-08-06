<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMediablesTable extends Migration
{
    public function up()
    {
        Schema::table('mediables', function (Blueprint $table) {
            $table->dropColumn(['crop_x2', 'crop_y2', 'background_position']);
        });
        Schema::table('mediables', function (Blueprint $table) {
            $table->json('metadatas')->nullable();
        });
    }

    public function down()
    {
        Schema::table('mediables', function (Blueprint $table) {
            $table->integer('crop_x2')->nullable();
            $table->integer('crop_y2')->nullable();
            $table->string('background_position', 20)->default('top');
            $table->dropColumn('metadatas');
        });

    }
}

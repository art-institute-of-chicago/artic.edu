<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMediablesTable extends Migration
{
    public function up()
    {
        Schema::table('mediables', function (Blueprint $table) {
            $table->dropColumn('crop_x2');
            $table->dropColumn('crop_y2');
            $table->dropColumn('background_position');
            $table->json('metadatas');
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

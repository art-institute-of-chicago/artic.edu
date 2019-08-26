<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create3dModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('3d_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_id');
            $table->string('camera_position');
            $table->string('camera_target');
            $table->json('annotation_list');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('3d_models');
    }
}

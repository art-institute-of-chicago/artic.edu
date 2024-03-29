<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('3d_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model_url');
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
    public function down(): void
    {
        Schema::dropIfExists('3d_models');
    }
};

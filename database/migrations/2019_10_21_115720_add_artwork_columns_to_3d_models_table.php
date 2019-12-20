<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtworkColumnsTo3dModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->string('model_caption')->nullable();
            $table->unsignedInteger('artwork_id')->nullable();
            $table->foreign('artwork_id')->references('id')->on('artworks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->dropColumn(['model_caption', 'artwork_id']);
        });
    }
}

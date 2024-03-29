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
    public function down(): void
    {
        Schema::table('3d_models', function (Blueprint $table) {
            $table->dropColumn(['model_caption', 'artwork_id']);
        });
    }
};

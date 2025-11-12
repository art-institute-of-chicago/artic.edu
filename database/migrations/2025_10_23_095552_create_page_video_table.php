<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_page_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id');
            $table->foreignId('video_id');
            $table->integer('position');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_video');
    }
};

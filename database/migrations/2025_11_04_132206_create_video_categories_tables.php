<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_categories', function (Blueprint $table) {
            createDefaultTableFields($table, published: false);
            $table->string('name')->nullable(false)->unique();
        });
        Schema::create('video_video_category', function (Blueprint $table) {
            createDefaultTableFields($table, softDeletes: false, published: false);
            $table->foreignId('video_category_id');
            $table->foreignId('video_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_video_category');
        Schema::dropIfExists('video_categories');
    }
};

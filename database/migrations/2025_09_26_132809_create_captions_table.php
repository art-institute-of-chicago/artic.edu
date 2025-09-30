<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('captions', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->foreignId('video_id');
            $table->string('name', 150)->nullable();
            $table->enum('kind', ['asr', 'forced', 'standard']);
            $table->string('youtube_id')->unique();
            $table->index(['video_id', 'kind']);
        });
        Schema::create('caption_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'caption');
            $table->string('name', 150)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caption_translations');
        Schema::dropIfExists('captions');
    }
};

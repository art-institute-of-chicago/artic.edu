<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('is_captioned')->nullable();
        });
        Schema::table('captions', function (Blueprint $table) {
            $table->dropColumn('youtube_id');
            $table->longText('file')->nullable();
        });
        Schema::table('caption_translations', function (Blueprint $table) {
            $table->string('youtube_id')->nullable();
            $table->longText('file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('caption_translations', function (Blueprint $table) {
            $table->dropColumn(['file', 'youtube_id']);
        });
        Schema::table('captions', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->string('youtube_id')->nullable();
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('is_captioned');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('video_slugs', function (Blueprint $table) {
            $table->index(['video_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::table('video_slugs', function (Blueprint $table) {
            $table->dropIndex(['video_id', 'locale']);
        });
    }
};

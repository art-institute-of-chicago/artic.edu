<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('is_short')->default(false);
            $table->text('description')->nullable();
        });
        Schema::table('playlist_video', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['is_short', 'description']);
        });
        Schema::table('playlist_video', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
};

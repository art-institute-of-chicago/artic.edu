<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->text('home_video_title')->nullable();
            $table->text('home_video_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_video_title');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('home_video_description');
        });
    }
};

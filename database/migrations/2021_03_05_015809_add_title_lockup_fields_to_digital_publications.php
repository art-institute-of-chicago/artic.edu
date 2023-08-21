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
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->text('header_title_display')->nullable();
            $table->text('header_subtitle_display')->nullable();
            $table->text('sidebar_title_display')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn([
                'header_title_display',
                'header_subtitle_display',
                'sidebar_title_display',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->boolean('archived')->default(false);
            $table->string('grouping_background_color')->nullable();
            $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('digital_labels', function (Blueprint $table) {
            $table->dropColumn(['archived', 'grouping_background_color', 'color']);
        });
    }
};

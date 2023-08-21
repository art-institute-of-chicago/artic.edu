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
        Schema::create('location_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'location');
            $table->string('name')->nullable();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('location_translations');
        Schema::table('locations', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
    }
};

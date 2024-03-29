<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->boolean('landing')->default(true)->index();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('landing')->default(true)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropColumn('landing');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('landing');
        });
    }
};

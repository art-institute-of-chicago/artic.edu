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
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'is_after_hours')) {
                $table->boolean('is_after_hours')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'is_after_hours')) {
                $table->dropColumn('is_after_hours');
            }
        });
    }
};

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
            $table->dropColumn('type');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('type')->index()->default(1);
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
            $table->dropColumn('type');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->integer('type')->index()->default(0);
        });
    }
};

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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('migrated_slug')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('migrated_slug')->nullable();
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->string('migrated_slug')->nullable();
        });

        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->string('migrated_slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('migrated_slug');
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->dropColumn('migrated_slug');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('migrated_slug');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('migrated_slug');
        });
    }
};

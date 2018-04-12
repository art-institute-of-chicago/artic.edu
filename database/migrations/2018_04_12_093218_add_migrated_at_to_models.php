<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMigratedAtToModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->datetime('migrated_at')->nullable();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->datetime('migrated_at')->nullable();
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->datetime('migrated_at')->nullable();
        });

        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->datetime('migrated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('migrated_at');
        });

        Schema::table('press_releases', function (Blueprint $table) {
            $table->dropColumn('migrated_at');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('migrated_at');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('migrated_at');
        });
    }
}

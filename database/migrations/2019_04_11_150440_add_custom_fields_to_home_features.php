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
        Schema::table('home_features', function (Blueprint $table) {
            $table->string('tag')->nullable();
            $table->string('call_to_action')->nullable();
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('home_features', function (Blueprint $table) {
            $table->dropColumn('tag');
        });

        Schema::table('home_features', function (Blueprint $table) {
            $table->dropColumn('call_to_action');
        });

        Schema::table('home_features', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};

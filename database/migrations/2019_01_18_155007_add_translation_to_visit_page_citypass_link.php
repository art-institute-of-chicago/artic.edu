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
        Schema::table('page_translations', function (Blueprint $table) {
            $table->string('visit_city_pass_link')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_city_pass_link');
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
            $table->string('visit_city_pass_link')->nullable();
        });

        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropColumn('visit_city_pass_link');
        });
    }
};

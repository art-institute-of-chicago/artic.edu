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
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->integer('publication_year')->default(0);
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->integer('publication_year')->default(0);
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
            $table->dropColumn('publication_year');
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->dropColumn('publication_year');
        });
    }
};

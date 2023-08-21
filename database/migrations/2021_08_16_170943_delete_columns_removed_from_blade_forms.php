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
        Schema::table('category_terms', function (Blueprint $table) {
            $table->dropColumn(['local_title', 'local_subtype']);
        });

        Schema::table('digital_publications', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'publication_year']);
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('blade_forms', function (Blueprint $table) {
        });
    }
};

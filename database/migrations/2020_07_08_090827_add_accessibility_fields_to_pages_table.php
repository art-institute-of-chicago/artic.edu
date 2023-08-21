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
            $table->text('visit_accessibility_text')->nullable();
            $table->text('visit_accessibility_link_text')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->text('visit_accessibility_link_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('page_translations', function (Blueprint $table) {
            $table->dropColumn(['visit_accessibility_text', 'visit_accessibility_link_text']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_accessibility_link_url');
        });
    }
};

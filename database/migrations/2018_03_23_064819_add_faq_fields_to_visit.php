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
        Schema::table('pages', function (Blueprint $table) {
            $table->text('visit_faq_accessibility_link')->nullable();
            $table->text('visit_faq_more_link')->nullable();
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
            $table->dropColumn('visit_faq_accessibility_link');
            $table->dropColumn('visit_faq_more_link');
        });
    }
};

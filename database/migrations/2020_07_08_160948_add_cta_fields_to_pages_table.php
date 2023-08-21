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
        Schema::table('page_translations', function (Blueprint $table) {
            $table->text('visit_cta_module_header')->nullable();
            $table->text('visit_cta_module_body')->nullable();
            $table->text('visit_cta_module_button_text')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->text('visit_cta_module_action_url')->nullable();
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
            $table->dropColumn([
                'visit_cta_module_header',
                'visit_cta_module_body',
                'visit_cta_module_button_text',
            ]);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_cta_module_action_url');
        });
    }
};

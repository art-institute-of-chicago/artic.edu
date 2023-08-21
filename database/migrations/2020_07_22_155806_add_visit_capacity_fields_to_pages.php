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
            $table->text('visit_capacity_alt')->nullable();
            $table->text('visit_capacity_heading')->nullable();
            $table->text('visit_capacity_text')->nullable();
            $table->text('visit_capacity_btn_text_1')->nullable();
            $table->text('visit_capacity_btn_text_2')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->text('visit_capacity_btn_url_1')->nullable();
            $table->text('visit_capacity_btn_url_2')->nullable();
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
                'visit_capacity_alt',
                'visit_capacity_heading',
                'visit_capacity_text',
                'visit_capacity_btn_text_1',
                'visit_capacity_btn_text_2',
            ]);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'visit_capacity_btn_url_1',
                'visit_capacity_btn_url_2',
            ]);
        });
    }
};

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
            $table->string('home_plan_your_visit_link_1_text')->nullable();
            $table->text('home_plan_your_visit_link_1_url')->nullable();
            $table->string('home_plan_your_visit_link_2_text')->nullable();
            $table->text('home_plan_your_visit_link_2_url')->nullable();
            $table->string('home_plan_your_visit_link_3_text')->nullable();
            $table->text('home_plan_your_visit_link_3_url')->nullable();
            $table->dropColumn(['home_plan_your_visit_link_text', 'home_plan_your_visit_link_url']);
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
            $table->string('home_plan_your_visit_link_text')->nullable();
            $table->text('home_plan_your_visit_link_url')->nullable();
            $table->dropColumn(['home_plan_your_visit_link_1_text', 'home_plan_your_visit_link_1_url', 'home_plan_your_visit_link_2_text', 'home_plan_your_visit_link_2_url', 'home_plan_your_visit_link_3_text', 'home_plan_your_visit_link_3_url']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('page_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'page');
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->string('visit_hour_subheader')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['visit_intro', 'visit_hour_header', 'visit_hour_subheader', 'visit_city_pass_title', 'visit_city_pass_text', 'visit_city_pass_button_label', 'visit_admission_description', 'visit_buy_tickets_label', 'visit_become_member_label']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('page_translations');
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->string('visit_hour_subheader')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
        });
    }
};

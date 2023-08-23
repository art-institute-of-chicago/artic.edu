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
        //
        // Pages

        // Add the columns to the main table
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->text('visit_hour_subheader')->nullable();
            $table->text('visit_hour_intro')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->string('visit_city_pass_link')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
            $table->text('visit_accessibility_text')->nullable();
            $table->text('visit_accessibility_link_text')->nullable();
            $table->text('visit_cta_module_header')->nullable();
            $table->text('visit_cta_module_body')->nullable();
            $table->text('visit_cta_module_button_text')->nullable();
            $table->text('visit_what_to_expect_more_text')->nullable();
            $table->text('visit_capacity_alt')->nullable();
            $table->text('visit_capacity_heading')->nullable();
            $table->text('visit_capacity_text')->nullable();
            $table->text('visit_capacity_btn_text_1')->nullable();
            $table->text('visit_capacity_btn_text_2')->nullable();
            $table->text('visit_hour_image_caption')->nullable();
        });

        //
        // Dining hours
        Schema::table('dining_hours', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->text('hours')->nullable();
        });

        //
        // Families
        Schema::table('families', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('link_label')->nullable();
        });

        //
        // FAQs
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

        //
        // Featured hours
        Schema::table('featured_hours', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->text('copy')->nullable();
        });

        //
        // Fee ages
        Schema::table('fee_ages', function (Blueprint $table) {
            $table->string('title')->nullable();
        });

        //
        // Fee category
        Schema::table('fee_categories', function (Blueprint $table) {
            $table->string('title')->nullable();
            $table->string('tooltip')->nullable();
        });

        //
        // Locations
        Schema::table('locations', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        //
        // What to expects
        Schema::table('what_to_expects', function (Blueprint $table) {
            $table->text('text')->nullable();
        });

        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('dining_hour_translations');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('family_translations');
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('featured_hour_translations');
        Schema::dropIfExists('fee_age_translations');
        Schema::dropIfExists('fee_category_translations');
        Schema::dropIfExists('generic_page_translations');
        Schema::dropIfExists('location_translations');
        Schema::dropIfExists('press_release_translations');
        Schema::dropIfExists('research_guide_translations');
        Schema::dropIfExists('slide_translations');
        Schema::dropIfExists('what_to_expect_translations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};

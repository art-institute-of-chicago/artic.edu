<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            // These are still actively used in the `labels` JSON field
            $table->dropColumn('visit_admission_intro');
            $table->dropColumn('visit_admission_members_label');
            $table->dropColumn('visit_admission_members_link');
            $table->dropColumn('visit_admission_tix_label');
            $table->dropColumn('visit_admission_tix_link');
            $table->dropColumn('visit_faq_more_link');
            $table->dropColumn('visit_faqs_label');
            $table->dropColumn('visit_faqs_link');
            $table->dropColumn('visit_members_intro');
            $table->dropColumn('visit_nav_buy_tix_label');
            $table->dropColumn('visit_nav_buy_tix_link');
            $table->dropColumn('visit_parking_label');
            $table->dropColumn('visit_parking_link');

            // These have been replaced by block content and are no longer used
            $table->dropColumn('visit_accessibility_link_text');
            $table->dropColumn('visit_accessibility_link_url');
            $table->dropColumn('visit_accessibility_text');
            $table->dropColumn('visit_admission_description');
            $table->dropColumn('visit_become_member_label');
            $table->dropColumn('visit_become_member_link');
            $table->dropColumn('visit_buy_tickets_label');
            $table->dropColumn('visit_buy_tickets_link');
            $table->dropColumn('visit_capacity_alt');
            $table->dropColumn('visit_capacity_btn_text_1');
            $table->dropColumn('visit_capacity_btn_text_2');
            $table->dropColumn('visit_capacity_btn_url_1');
            $table->dropColumn('visit_capacity_btn_url_2');
            $table->dropColumn('visit_capacity_heading');
            $table->dropColumn('visit_capacity_text');
            $table->dropColumn('visit_city_pass_button_label');
            $table->dropColumn('visit_city_pass_link');
            $table->dropColumn('visit_city_pass_text');
            $table->dropColumn('visit_city_pass_title');
            $table->dropColumn('visit_cta_module_action_url');
            $table->dropColumn('visit_cta_module_body');
            $table->dropColumn('visit_cta_module_button_text');
            $table->dropColumn('visit_cta_module_header');
            $table->dropColumn('visit_dining_link');
            $table->dropColumn('visit_faq_accessibility_link');
            $table->dropColumn('visit_hours_intro');
            $table->dropColumn('visit_intro');
            $table->dropColumn('visit_parking_accessibility_link');
            $table->dropColumn('visit_transportation_link');
            $table->dropColumn('visit_what_to_expect_more_link');
            $table->dropColumn('visit_what_to_expect_more_text');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->text('visit_accessibility_link_text')->nullable();
            $table->text('visit_accessibility_link_url')->nullable();
            $table->text('visit_accessibility_text')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->text('visit_admission_intro')->nullable();
            $table->string('visit_become_member_label')->nullable();
            $table->string('visit_become_member_link')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_buy_tickets_link')->nullable();
            $table->text('visit_capacity_alt')->nullable();
            $table->text('visit_capacity_btn_text_1')->nullable();
            $table->text('visit_capacity_btn_text_2')->nullable();
            $table->text('visit_capacity_btn_url_1')->nullable();
            $table->text('visit_capacity_btn_url_2')->nullable();
            $table->text('visit_capacity_heading')->nullable();
            $table->text('visit_capacity_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->string('visit_city_pass_link')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_cta_module_action_url')->nullable();
            $table->text('visit_cta_module_body')->nullable();
            $table->text('visit_cta_module_button_text')->nullable();
            $table->text('visit_cta_module_header')->nullable();
            $table->text('visit_dining_link')->nullable();
            $table->text('visit_faq_accessibility_link')->nullable();
            $table->text('visit_faq_more_link')->nullable();
            $table->string('visit_faqs_label')->nullable();
            $table->string('visit_faqs_link')->nullable();
            $table->text('visit_hour_intro')->nullable();
            $table->string('visit_intro')->nullable();
            $table->text('visit_members_intro')->nullable();
            $table->text('visit_nav_buy_tix_label')->nullable();
            $table->text('visit_nav_buy_tix_link')->nullable();
            $table->string('visit_parking_accessibility_link')->nullable();
            $table->string('visit_parking_link')->nullable();
            $table->string('visit_transportation_link')->nullable();
            $table->text('visit_what_to_expect_more_link')->nullable();
            $table->text('visit_what_to_expect_more_text')->nullable();
        });
    }
};

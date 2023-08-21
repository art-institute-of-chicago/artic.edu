<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    private $tablesToAddLandingPageIdTo = [
        'featured_hours',
        'home_artists',
        'locations',
        'faqs',
        'families',
        'what_to_expects',
        'dining_hours',
        'page_printed_publication',
        'page_home_secondary_home_feature',
        'page_home_main_home_feature',
        'page_home_home_feature',
        'page_home_event',
        'page_article_category',
        'page_art_article',
        'article_page',
        'experience_page',
        'digital_publication_page',
        'research_resource_feature_page',
        'research_resource_study_room_pages',
        'research_resource_study_room_more_pages'
    ];

    public function up(): void
    {
        Schema::create('landing_page_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_type', 255)->unique();
            $table->timestamps();
        });

        DB::statement("INSERT INTO landing_page_types (page_type)
        VALUES ('Home'),
               ('Exhibitions and Events'),
               ('Collection'),
               ('Visit'),
               ('Articles'),
               ('Exhibition History'),
               ('Art and Ideas'),
               ('Research and Resources'),
               ('Articles and Publications'),
               ('Stories'),
               ('Custom');");

        // Create landing_pages tables
        // Use existing 'pages' tables for data structure
        Schema::create('landing_pages', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true);
            $table->integer('position')->unsigned()->index();
            $table->string('title');
            $table->integer('type')->unsigned();
            $table->unique('type');
            $table->text('home_intro')->nullable();
            $table->text('exhibition_intro')->nullable();
            $table->text('art_intro')->nullable();
            $table->string('exhibition_history_sub_heading')->nullable();
            $table->text('exhibition_history_intro_copy')->nullable();
            $table->text('exhibition_history_popup_copy')->nullable();
            $table->text('home_cta_module_action_url')->nullable();
            $table->text('home_cta_module_header')->nullable();
            $table->text('home_cta_module_body')->nullable();
            $table->string('home_cta_module_button_text')->nullable();
            $table->string('visit_transportation_link')->nullable();
            $table->string('visit_parking_link')->nullable();
            $table->string('visit_buy_tickets_link')->nullable();
            $table->string('visit_become_member_link')->nullable();
            $table->text('visit_faq_accessibility_link')->nullable();
            $table->text('visit_faq_more_link')->nullable();
            $table->text('printed_publications_intro')->nullable();
            $table->text('resources_landing_title')->nullable();
            $table->text('resources_landing_intro')->nullable();
            $table->text('visit_dining_link')->nullable();
            $table->string('home_plan_your_visit_link_1_text')->nullable();
            $table->text('home_plan_your_visit_link_1_url')->nullable();
            $table->string('home_plan_your_visit_link_2_text')->nullable();
            $table->text('home_plan_your_visit_link_2_url')->nullable();
            $table->string('home_plan_your_visit_link_3_text')->nullable();
            $table->text('home_plan_your_visit_link_3_url')->nullable();
            $table->text('home_video_title')->nullable();
            $table->text('home_video_description')->nullable();
            $table->integer('home_cta_module_variation')->default(1);
            $table->text('home_cta_module_form_id')->nullable();
            $table->text('home_cta_module_form_token')->nullable();
            $table->text('home_cta_module_form_tlc_source')->nullable();
            $table->string('visit_parking_accessibility_link')->nullable();
            $table->text('visit_accessibility_link_url')->nullable();
            $table->text('visit_cta_module_action_url')->nullable();
            $table->text('visit_what_to_expect_more_link')->nullable();
            $table->text('visit_capacity_btn_url_1')->nullable();
            $table->text('visit_capacity_btn_url_2')->nullable();
            $table->text('home_visit_button_text')->nullable();
            $table->text('home_visit_button_url')->nullable();
            $table->boolean('visit_hide_hours')->nullable();
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

            // Additional landing page builder fields
            $table->text('visit_nav_buy_tix_label')->nullable();
            $table->text('visit_nav_buy_tix_link')->nullable();
            $table->text('visit_hours_intro')->nullable();
            $table->text('visit_members_intro')->nullable();
            $table->text('visit_admission_intro')->nullable();
            $table->string('page_type')->references('page_type')->on('landing_page_types')->nullable();
        });

        Schema::create('landing_page_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'landing_page');
        });

        Schema::create('landing_page_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'landing_page');
        });

        Schema::create('landing_page_categories', function (Blueprint $table) {
            createDefaultTableFields($table, true, false);
            $table->string('name');
        });

        Schema::create('landing_page_category_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'landing_page_category');
        });

        // Create column in relational tables to match landing_page_id instead of page_id
        foreach ($this->tablesToAddLandingPageIdTo as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->integer('landing_page_id')->references('id')->on('landing_pages')->nullable();
            });
        }

        // Mapped relational tables:
        //
        // page_printed_publication
        // page_printed_catalog_id_seq
        // page_home_secondary_home_feature_id_seq
        // page_home_secondary_home_feature
        // page_home_main_home_feature_id_seq
        // page_home_main_home_feature
        // page_home_home_feature_id_s
        // page_home_home_feature
        // page_home_event_id_seq
        // page_home_event
        // page_category_slugs_id_seq
        // page_category_slugs
        // page_article_category_id_seq
        // page_article_category
        // page_art_article_id_seq
        // page_art_article
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_page_revisions');
        Schema::dropIfExists('landing_page_category_slugs');
        Schema::dropIfExists('landing_page_categories');
        Schema::dropIfExists('landing_page_slugs');

        foreach ($this->tablesToAddLandingPageIdTo as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('landing_page_id');
            });
        }

        Schema::dropIfExists('landing_pages');
        Schema::dropIfExists('landing_page_types');
    }
};

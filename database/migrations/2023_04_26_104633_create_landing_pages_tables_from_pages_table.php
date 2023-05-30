<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLandingPagesTablesFromPagesTable extends Migration
{
    public function up()
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
        DB::statement('CREATE TABLE landing_pages AS TABLE pages');
        DB::statement('CREATE SEQUENCE landing_pages_id_seq AS integer');
        DB::statement("ALTER TABLE landing_pages ALTER COLUMN id SET DEFAULT nextval('landing_pages_id_seq'::regclass)");
        DB::statement('ALTER TABLE landing_pages ADD CONSTRAINT landing_pages_id_unique UNIQUE (id)');
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->text('visit_nav_buy_tix_label')->nullable();
            $table->text('visit_nav_buy_tix_link')->nullable();
            $table->text('visit_hours_intro')->nullable();
            $table->text('visit_members_intro')->nullable();
            $table->text('visit_admission_intro')->nullable();
            $table->string('page_type')->references('page_type')->on('landing_page_types')->nullable();
        });
        DB::statement('TRUNCATE TABLE landing_pages');

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

        foreach (['featured_hours', 'home_artists', 'locations', 'faqs', 'families', 'what_to_expects', 'dining_hours',
                  'page_printed_publication', 'page_home_secondary_home_feature', 'page_home_main_home_feature', 'page_home_home_feature', 'page_home_event',
                  'page_article_category', 'page_art_article', 'article_page', 'experience_page', 'digital_publication_page',
                  'research_resource_feature_page', 'research_resource_study_room_pages', 'research_resource_study_room_more_pages'] as $t) {
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

    public function down()
    {
        DB::statement('ALTER TABLE page_printed_publication DROP CONSTRAINT page_printed_publication_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_home_secondary_home_feature DROP CONSTRAINT page_home_secondary_home_feature_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_home_main_home_feature DROP CONSTRAINT page_home_main_home_feature_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_home_home_feature DROP CONSTRAINT page_home_home_feature_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_home_event DROP CONSTRAINT page_home_event_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_article_category DROP CONSTRAINT page_article_category_landing_page_id_foreign');
        DB::statement('ALTER TABLE page_art_article DROP CONSTRAINT page_art_article_landing_page_id_foreign');

        DB::statement('DROP TABLE IF EXISTS landing_pages');
        DB::statement('DROP SEQUENCE IF EXISTS landing_pages_id_seq');

        DB::statement('DROP TABLE IF EXISTS landing_page_types');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_types_id_seq');

        DB::statement('DROP TABLE IF EXISTS landing_page_slugs');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_slugs_id_seq');

        DB::statement('DROP TABLE IF EXISTS landing_page_categories');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_categories_id_seq');

        DB::statement('DROP TABLE IF EXISTS landing_page_category_slugs');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_category_slugs_id_seq');

        DB::statement('DROP TABLE IF EXISTS landing_page_revisions');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_revisions_id_seq');

        DB::statement('ALTER TABLE home_artists DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE featured_hours DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE locations DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE faqs DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE families DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE what_to_expects DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE dining_hours DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_printed_publication DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_home_secondary_home_feature DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_home_main_home_feature DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_home_home_feature DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_home_event DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_article_category DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE page_art_article DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE article_page DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE experience_page DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE digital_publication_page DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE research_resource_feature_page DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE research_resource_study_room_pages DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE research_resource_study_room_more_pages DROP COLUMN landing_page_id');
    }
}

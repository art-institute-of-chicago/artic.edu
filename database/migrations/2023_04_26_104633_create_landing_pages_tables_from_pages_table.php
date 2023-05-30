<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLandingPagesTablesFromPagesTable extends Migration
{
    public function up()
    {
        // Create landing_pages tables

        DB::statement('CREATE TABLE landing_pages AS TABLE pages');
        DB::statement('ALTER TABLE landing_pages
                ADD COLUMN visit_nav_buy_tix_label TEXT,
                ADD COLUMN visit_nav_buy_tix_link TEXT,
                ADD COLUMN visit_hours_intro TEXT,
                ADD COLUMN visit_members_intro TEXT,
                ADD COLUMN visit_admission_intro TEXT');
        DB::statement('CREATE SEQUENCE landing_pages_id_seq AS integer');
        DB::statement("ALTER TABLE landing_pages ALTER COLUMN id SET DEFAULT nextval('landing_pages_id_seq'::regclass)");

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
        DB::statement("ALTER TABLE landing_pages ADD COLUMN page_type VARCHAR(255) REFERENCES landing_page_types(page_type)");

        // Use existing 'pages' tables for data structure

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

        DB::statement('ALTER TABLE featured_hours ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE home_artists ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE locations ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE faqs ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE families ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE what_to_expects ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE dining_hours ADD COLUMN landing_page_id INTEGER');

        // Remove NOT NULL constraint for page_id from tables

        DB::statement('ALTER TABLE featured_hours ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE home_artists ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE locations ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE faqs ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE families ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE what_to_expects ALTER COLUMN page_id DROP NOT NULL');
        DB::statement('ALTER TABLE dining_hours ALTER COLUMN page_id DROP NOT NULL');

        // Add landing_page_id to reference columns

        DB::statement('ALTER TABLE page_printed_publication ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_home_secondary_home_feature ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_home_main_home_feature ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_home_home_feature ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_home_event ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_article_category ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE page_art_article ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE article_page ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE experience_page ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE digital_publication_page ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE research_resource_feature_page ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE research_resource_study_room_pages ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE research_resource_study_room_more_pages ADD COLUMN landing_page_id INTEGER');

        // Truncate stmts to be used when in prod to clear copied data

        DB::statement('TRUNCATE TABLE landing_pages');

        // Add foreign constraints from landing_page_id to landing_pages(id)

        DB::statement('ALTER TABLE landing_pages ADD CONSTRAINT landing_pages_id_unique UNIQUE (id)');

        DB::statement('ALTER TABLE page_printed_publication ADD CONSTRAINT page_printed_publication_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_home_secondary_home_feature ADD CONSTRAINT page_home_secondary_home_feature_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_home_main_home_feature ADD CONSTRAINT page_home_main_home_feature_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_home_home_feature ADD CONSTRAINT page_home_home_feature_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_home_event ADD CONSTRAINT page_home_event_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_article_category ADD CONSTRAINT page_article_category_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE page_art_article ADD CONSTRAINT page_art_article_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE article_page ADD CONSTRAINT article_page_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE experience_page ADD CONSTRAINT experience_page_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE digital_publication_page ADD CONSTRAINT digital_publication_page_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE research_resource_feature_page ADD CONSTRAINT research_resource_feature_page_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE research_resource_study_room_pages ADD CONSTRAINT research_resource_study_room_pages_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');
        DB::statement('ALTER TABLE research_resource_study_room_more_pages ADD CONSTRAINT research_resource_study_room_more_pages_landing_page_id_foreign FOREIGN KEY (landing_page_id) REFERENCES landing_pages(id)');


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

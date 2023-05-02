<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLandingPagesTablesFromPagesTable extends Migration
{
    public function up()
    {
        // Create landing_pages tables

        DB::statement('CREATE TABLE landing_pages AS TABLE pages');
        DB::statement('CREATE SEQUENCE landing_pages_id_seq AS integer');

        // Use existing 'pages' tables for data structure

        DB::statement('CREATE TABLE landing_page_slugs AS TABLE page_slugs');
        DB::statement('ALTER TABLE landing_page_slugs RENAME COLUMN page_id TO landing_page_id');
        DB::statement('CREATE SEQUENCE landing_page_slugs_id_seq AS integer');
        DB::statement("ALTER TABLE landing_page_slugs ALTER COLUMN id SET DEFAULT nextval('landing_page_slugs_id_seq'::regclass)");

        DB::statement('CREATE TABLE landing_page_revisions AS TABLE page_revisions');
        DB::statement('ALTER TABLE landing_page_revisions RENAME COLUMN page_id TO landing_page_id');
        DB::statement('CREATE SEQUENCE landing_page_revisions_id_seq AS integer');
        DB::statement("ALTER TABLE landing_page_revisions ALTER COLUMN id SET DEFAULT nextval('landing_page_revisions_id_seq'::regclass)");

        DB::statement('CREATE TABLE landing_page_categories AS TABLE page_categories');
        DB::statement('CREATE SEQUENCE landing_page_categories_id_seq AS integer');
        DB::statement("ALTER TABLE landing_page_categories ALTER COLUMN id SET DEFAULT nextval('landing_page_categories_id_seq'::regclass)");

        DB::statement('CREATE TABLE landing_page_category_slugs AS TABLE page_category_slugs');
        DB::statement('CREATE SEQUENCE landing_page_category_slugs_id_seq AS integer');
        DB::statement("ALTER TABLE landing_page_category_slugs ALTER COLUMN id SET DEFAULT nextval('landing_page_category_slugs_id_seq'::regclass)");

        // Create column in relational tables to match landing_page_id instead of page_id

        DB::statement('ALTER TABLE home_artists ADD COLUMN landing_page_id INTEGER');
        DB::statement('ALTER TABLE featured_hours ADD COLUMN landing_page_id INTEGER');

        // Truncate stmts to be used when in prod to clear copied data

        // DB::statement('TRUNCATE TABLE landing_pages');
        // DB::statement('TRUNCATE TABLE landing_page_slugs');
        // DB::statement('TRUNCATE TABLE landing_page_revisions');
        // DB::statement('TRUNCATE TABLE landing_page_categories');
        // DB::statement('TRUNCATE TABLE landing_page_category_slugs');

        // Mapped relational tables:
        //
        // page_printed_publication
        // page_printed_catalog_id_seq
        // page_home_secondary_home_feature_id_seq
        // page_home_secondary_home_feature
        // page_home_main_home_feature_id_seq
        // page_home_main_home_feature
        // page_home_home_feature_id_seq
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
        DB::statement('DROP TABLE IF EXISTS landing_pages');
        DB::statement('DROP SEQUENCE IF EXISTS landing_pages_id');
        DB::statement('DROP TABLE IF EXISTS landing_page_slugs');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_slugs_id');
        DB::statement('DROP TABLE IF EXISTS landing_page_categories');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_categories_id');
        DB::statement('DROP TABLE IF EXISTS landing_page_category_slugs');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_category_slugs_id');
        DB::statement('DROP TABLE IF EXISTS landing_page_revisions');
        DB::statement('DROP SEQUENCE IF EXISTS landing_page_revisions_id');
        DB::statement('ALTER TABLE home_artists DROP COLUMN landing_page_id');
        DB::statement('ALTER TABLE featured_hours DROP COLUMN landing_page_id');
    }
}

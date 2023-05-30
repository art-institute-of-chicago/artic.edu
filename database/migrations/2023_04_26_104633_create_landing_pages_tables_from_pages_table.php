<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLandingPagesTablesFromPagesTable extends Migration
{
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

    public function down()
    {
        Schema::table('page_printed_publication', function (Blueprint $table) {
            $table->dropForeign('page_printed_publication_landing_page_id_foreign');
        });
        Schema::table('page_home_secondary_home_feature', function (Blueprint $table) {
            $table->dropForeign('page_home_secondary_home_feature_landing_page_id_foreign');
        });
        Schema::table('page_home_main_home_feature', function (Blueprint $table) {
            $table->dropForeign('page_home_main_home_feature_landing_page_id_foreign');
        });
        Schema::table('page_home_home_feature', function (Blueprint $table) {
            $table->dropForeign('page_home_home_feature_landing_page_id_foreign');
        });
        Schema::table('page_home_event', function (Blueprint $table) {
            $table->dropForeign('page_home_event_landing_page_id_foreign');
        });
        Schema::table('page_article_category', function (Blueprint $table) {
            $table->dropForeign('page_article_category_landing_page_id_foreign');
        });
        Schema::table('page_art_article', function (Blueprint $table) {
            $table->dropForeign('page_art_article_landing_page_id_foreign');
        });

        Schema::dropIfExists('landing_page_revisions');
        Schema::dropIfExists('landing_page_category_slugs');
        Schema::dropIfExists('landing_page_categories');
        Schema::dropIfExists('landing_page_slugs');
        Schema::dropIfExists('landing_page_types');
        Schema::dropIfExists('landing_pages');

        foreach ($this->tablesToAddLandingPageIdTo as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('landing_page_id');
            });
        }
    }
}

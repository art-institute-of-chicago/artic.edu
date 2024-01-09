<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesForLandingPageHome extends Migration
{
    // The migrations here create tables that reflect the ones currently used in the static Home page
    // and repurposes them for ALL landing pages.

    // This comprises of a 'feature_page_$' table and a 'landing_page_$' table

    public function up()
    {

        // Create the base table for features to build relationships between 'page_features' and 'landing pages'

        Schema::create('page_features', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->unsignedBigInteger('landing_page_id')->nullable();
            $table->integer('position')->nullable();
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
            $table->string('title')->nullable();
            $table->string('tag')->nullable();
            $table->string('call_to_action')->nullable();
            $table->string('url')->nullable();
        });

        Schema::create('landing_page_page_feature', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->unsignedBigInteger('page_feature_id')->nullable();
            $table->unsignedBigInteger('landing_page_id')->nullable();
            $table->integer('position');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });


        Schema::create('landing_page_primary_page_feature', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->unsignedBigInteger('page_feature_id')->nullable();
            $table->unsignedBigInteger('landing_page_id')->nullable();
            $table->integer('position');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        Schema::create('landing_page_secondary_page_feature', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->unsignedBigInteger('page_feature_id')->nullable();
            $table->unsignedBigInteger('landing_page_id')->nullable();
            $table->integer('position');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        //
        // The following migrations copy existing structure of the unique Home page feature relational tables
        // and references them back to landing pages.
        //

        // EXHIBITIONS
        //
        // NOTE: Exhibitions are API augmented and will not have a page relational table to match it back to page_feature

        Schema::create('landing_page_exhibition', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('exhibition_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        // EVENTS

        Schema::create('landing_page_event', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        Schema::create('event_page_feature', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('page_feature_id');
            $table->integer('position');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
        });

        // ARTICLES
        //
        // NOTE: Articles have constraints with their category so additional references need to be made to separate them from static pages

        Schema::create('landing_page_art_articles', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        Schema::create('article_page_feature', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('page_feature_id');
            $table->integer('position');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
        });

        // For search by category on the `Articles` landing page

        Schema::create('landing_page_article_category', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('article_category_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('article_category_id')->references('id')->on('article_category')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        // Printed Publications

        Schema::create('landing_page_printed_publications', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('printed_publication_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('printed_publication_id')->references('id')->on('printed_publications')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        // HIGHLIGHTS

        Schema::create('landing_page_highlights', function (Blueprint $table) {
            createDefaultTableFields($table);
            $table->unsignedBigInteger('highlight_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('highlight_id')->references('id')->on('highlights')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });

        Schema::create('highlight_page_feature', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('highlight_id');
            $table->unsignedBigInteger('page_feature_id');
            $table->integer('position');
            $table->foreign('highlight_id')->references('id')->on('highlights')->onDelete('cascade');
            $table->foreign('page_feature_id')->references('id')->on('page_features')->onDelete('cascade');
        });

        // GENERIC PAGES

        Schema::create('landing_page_generic_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->unsignedBigInteger('generic_page_id');
            $table->unsignedBigInteger('landing_page_id');
            $table->integer('position');
            $table->foreign('generic_page_id')->references('id')->on('generic_pages')->onDelete('cascade');
            $table->foreign('landing_page_id')->references('id')->on('landing_pages')->onDelete('cascade');
            $table->index('position');
        });
    }
    public function down()
    {
        Schema::dropIfExists('landing_page_printed_publications');
        Schema::dropIfExists('landing_page_generic_pages');
        Schema::dropIfExists('highlight_page_feature');
        Schema::dropIfExists('landing_page_highlights');
        Schema::dropIfExists('landing_page_article_category');
        Schema::dropIfExists('article_page_feature');
        Schema::dropIfExists('landing_page_art_articles');
        Schema::dropIfExists('event_page_feature');
        Schema::dropIfExists('landing_page_event');
        Schema::dropIfExists('landing_page_exhibition');
        Schema::dropIfExists('landing_page_page_feature');
        Schema::dropIfExists('page_secondary_features');
        Schema::dropIfExists('page_features');
    }
}

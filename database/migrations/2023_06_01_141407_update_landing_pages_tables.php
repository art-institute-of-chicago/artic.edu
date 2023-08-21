<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        foreach ($this->tablesToAddLandingPageIdTo as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->integer('page_id')->nullable()->change();
                $table->integer('landing_page_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
    }
};

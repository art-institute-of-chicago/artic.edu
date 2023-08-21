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
        // First, we need to fix the `related_unique` key in the `related` table.
        // Looks like Twill added the `browser_name` field to the key.
        // If we don't do this, we can't relate any two items in more than one way.
        Schema::table('related', function (Blueprint $table) {
            $table->dropUnique('related_unique');
            $table->unique(
                ['subject_id', 'subject_type', 'related_id', 'related_type', 'browser_name'],
                'related_unique'
            );
        });

        Schema::dropIfExists('article_event_sidebar');
        Schema::dropIfExists('article_article_sidebar');
        Schema::dropIfExists('article_video');
        Schema::dropIfExists('artwork_event');
        Schema::dropIfExists('article_artwork');
        Schema::dropIfExists('artwork_experience');
        Schema::dropIfExists('artwork_video');
        Schema::dropIfExists('exhibition_event_sidebar');
        Schema::dropIfExists('article_exhibition');
        Schema::dropIfExists('exhibition_video');
        Schema::dropIfExists('event_generic_page');
        Schema::dropIfExists('article_generic_page');
        Schema::dropIfExists('article_selection');
        Schema::dropIfExists('event_selection_sidebar');
        Schema::dropIfExists('selection_video');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // CreateArticleEventSidebarTable
        Schema::create('article_event_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'article', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // CreateArticleArticleSidebarTable
        Schema::create('article_article_sidebar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('related_article_id')->unsigned();
            $table->foreign('related_article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->index(['related_article_id', 'article_id']);
            $table->integer('position')->unsigned()->index();
        });

        // CreateArticleVideoTable
        Schema::create('article_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'video');
            $table->integer('position')->unsigned()->index();
        });

        // CreateArtwork2Table
        Schema::create('artwork_event', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'artwork', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // CreateArtwork2Table
        Schema::create('article_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'artwork');
            $table->integer('position')->unsigned()->index();
        });

        // CreateArtworkExperienceTable
        Schema::create('artwork_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->integer('artwork_id')->unsigned();
            $table->foreign('artwork_id')->references('id')->on('artworks')->onDelete('cascade');
            $table->index(['artwork_id', 'experience_id'], 'artwork_experience_artwork_id_experience_id_idx');
            $table->integer('position')->unsigned()->index();
        });

        // CreateArtwork2Table
        Schema::create('artwork_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'artwork', 'video');
            $table->integer('position')->unsigned()->index();
        });

        // CreateExhibitionEventSidebarTable
        Schema::create('exhibition_event_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'event', 'exhibition');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // CreateArticleExhibitionTable2
        Schema::create('article_exhibition', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'article', 'exhibition');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // CreateExhibitionVideoTable
        Schema::create('exhibition_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'exhibition', 'video');
            $table->integer('position')->unsigned()->index();
        });

        // AddGenericPageRelated
        Schema::create('event_generic_page', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'generic_page', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // AddGenericPageRelated
        Schema::create('article_generic_page', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'generic_page', 'article');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // RecreateArticleSelectionTable
        Schema::create('article_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'selection');
            $table->integer('position')->unsigned()->index();
        });

        // CreateEventSelectionSidebarTable
        Schema::create('event_selection_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'event', 'selection');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        // CreateSelectionVideoTable
        Schema::create('selection_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'selection', 'video');
            $table->integer('position')->unsigned()->index();
        });

        Schema::table('related', function (Blueprint $table) {
            $table->dropUnique('related_unique');
            $table->unique(
                ['subject_id', 'subject_type', 'related_id', 'related_type'],
                'related_unique'
            );
        });
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateSidebarRelatedBrowsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

        DB::table('related')->where('browser_name', 'sidebar_items')->delete();

        foreach (DB::table('api_relatables')
            ->where('relation', '=', 'exhibitions')
            ->where('api_relatable_type', '=', 'App\Models\GenericPage')
            ->get() as $pivot
        ) {
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->api_relatable_id,
                'subject_type'  =>  'App\Models\GenericPage',
                'related_type'  =>  'exhibitions',
                'related_id'    =>  $pivot->api_relation_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        DB::table('api_relatables')
            ->where('relation', '=', 'exhibitions')
            ->where('api_relatable_type', '=', 'App\Models\GenericPage')
            ->delete();

        foreach ([
            'articles',
            'App\Models\Artwork',
            'exhibitions',
            'selections',
        ] as $type) {
            foreach (DB::table('api_relatables')
                ->where('relation', '=', 'sidebarExhibitions')
                ->where('api_relatable_type', '=', $type)
                ->get() as $pivot
            ) {
                DB::table('related')->insert([
                    'subject_id'    =>  $pivot->api_relatable_id,
                    'subject_type'  =>  $type,
                    'related_type'  =>  'exhibitions',
                    'related_id'    =>  $pivot->api_relation_id,
                    'browser_name'  =>  'sidebar_items',
                    'position'      =>  $pivot->position,
                ]);
            }

            DB::table('api_relatables')
                ->where('relation', '=', 'sidebarExhibitions')
                ->where('api_relatable_type', '=', $type)
                ->delete();
        }

        foreach (DB::table('article_event_sidebar')->select('*')->get() as $pivot) { // Article::sidebarEvent()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->article_id,
                'subject_type'  =>  'articles',
                'related_type'  =>  'events',
                'related_id'    =>  $pivot->event_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_article_sidebar')->select('*')->get() as $pivot) { // Article::sidebarArticle()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->article_id,
                'subject_type'  =>  'articles',
                'related_type'  =>  'articles',
                'related_id'    =>  $pivot->related_article_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_video')->select('*')->get() as $pivot) { // Article::videos()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->article_id,
                'subject_type'  =>  'articles',
                'related_type'  =>  'videos',
                'related_id'    =>  $pivot->video_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_event')->select('*')->get() as $pivot) { // Artwork::sidebarEvent()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->artwork_id,
                'subject_type'  =>  'App\Models\Artwork',
                'related_type'  =>  'events',
                'related_id'    =>  $pivot->event_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_artwork')->select('*')->get() as $pivot) { // Artwork::sidebarArticle()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->artwork_id,
                'subject_type'  =>  'App\Models\Artwork',
                'related_type'  =>  'articles',
                'related_id'    =>  $pivot->article_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_experience')->select('*')->get() as $pivot) { // Artwork::sidebarExperiences()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->artwork_id,
                'subject_type'  =>  'App\Models\Artwork',
                'related_type'  =>  'interactiveFeatures.experiences',
                'related_id'    =>  $pivot->experience_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_video')->select('*')->get() as $pivot) { // Artwork::videos()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->artwork_id,
                'subject_type'  =>  'App\Models\Artwork',
                'related_type'  =>  'videos',
                'related_id'    =>  $pivot->video_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('exhibition_event_sidebar')->select('*')->get() as $pivot) { // Exhibition::sidebarEvent()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->exhibition_id,
                'subject_type'  =>  'exhibitions',
                'related_type'  =>  'events',
                'related_id'    =>  $pivot->event_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_exhibition')->select('*')->get() as $pivot) { // Exhibition::articles()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->exhibition_id,
                'subject_type'  =>  'exhibitions',
                'related_type'  =>  'articles',
                'related_id'    =>  $pivot->article_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('exhibition_video')->select('*')->get() as $pivot) { // Exhibition::videos()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->exhibition_id,
                'subject_type'  =>  'exhibitions',
                'related_type'  =>  'videos',
                'related_id'    =>  $pivot->video_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('event_generic_page')->select('*')->get() as $pivot) { // GenericPage::events()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->generic_page_id,
                'subject_type'  =>  'App\Models\GenericPage',
                'related_type'  =>  'events',
                'related_id'    =>  $pivot->event_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_generic_page')->select('*')->get() as $pivot) { // GenericPage::articles()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->generic_page_id,
                'subject_type'  =>  'App\Models\GenericPage',
                'related_type'  =>  'articles',
                'related_id'    =>  $pivot->article_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('article_selection')->select('*')->get() as $pivot) { // Selection::articles() form, but also visible via Article::selections()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->selection_id,
                'subject_type'  =>  'selections',
                'related_type'  =>  'articles',
                'related_id'    =>  $pivot->article_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('event_selection_sidebar')->select('*')->get() as $pivot) { // Selection::sidebarEvent()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->selection_id,
                'subject_type'  =>  'selections',
                'related_type'  =>  'events',
                'related_id'    =>  $pivot->event_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

        foreach (DB::table('selection_video')->select('*')->get() as $pivot) { // Selection::videos()
            DB::table('related')->insert([
                'subject_id'    =>  $pivot->selection_id,
                'subject_type'  =>  'selections',
                'related_type'  =>  'videos',
                'related_id'    =>  $pivot->video_id,
                'browser_name'  =>  'sidebar_items',
                'position'      =>  $pivot->position,
            ]);
        }

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
    public function down()
    {
        $pivots = DB::table('related')->select('*')->where('browser_name', '=', 'sidebar_items')->get();

        foreach ($pivots->where('subject_type', '=', 'App\Models\GenericPage')->where('related_type', 'exhibitions') as $pivot) { // GenericPage::exhibitions()
            DB::table('api_relatables')->insert([
                'api_relatable_type' => 'App\Models\GenericPage',
                'api_relatable_id' => $pivot->subject_id,
                'api_relation_id' => $pivot->related_id,
                'relation' => 'exhibitions',
                'position' =>  $pivot->position,
            ]);
        }

        foreach ([
            'articles', // Article::sidebarExhibitions()
            'App\Models\Artwork', // Artwork::sidebarExhibitions()
            'exhibitions', // Exhibition::sidebarExhibitions()
            'selections', // Selection::sidebarExhibitions()
        ] as $type) {
            foreach ($pivots->where('subject_type', '=', $type)->where('related_type', 'exhibitions') as $pivot) {
                DB::table('api_relatables')->insert([
                    'api_relatable_type' => $type,
                    'api_relatable_id' => $pivot->subject_id,
                    'api_relation_id' => $pivot->related_id,
                    'relation' => 'sidebarExhibitions',
                    'position' =>  $pivot->position,
                ]);
            }
        }

        // CreateArticleEventSidebarTable
        Schema::create('article_event_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'article', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'articles')->where('related_type', 'events') as $pivot) { // Article::sidebarEvent()
            DB::table('article_event_sidebar')->insert([
                'article_id'    =>  $pivot->subject_id,
                'event_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArticleArticleSidebarTable
        Schema::create('article_article_sidebar', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("article_id")->unsigned();
            $table->foreign("article_id")->references('id')->on('articles')->onDelete('cascade');
            $table->integer("related_article_id")->unsigned();
            $table->foreign("related_article_id")->references('id')->on('articles')->onDelete('cascade');
            $table->index(["related_article_id", "article_id"]);
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'articles')->where('related_type', 'articles') as $pivot) { // Article::sidebarArticle()
            DB::table('article_article_sidebar')->insert([
                'article_id'    =>  $pivot->subject_id,
                'related_article_id' =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArticleVideoTable
        Schema::create('article_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'video');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'articles')->where('related_type', 'videos') as $pivot) { // Article::videos()
            DB::table('article_video')->insert([
                'article_id'    =>  $pivot->subject_id,
                'video_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArtwork2Table
        Schema::create('artwork_event', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'artwork', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\Artwork')->where('related_type', 'events') as $pivot) { // Artwork::sidebarEvent()
            DB::table('artwork_event')->insert([
                'artwork_id'    =>  $pivot->subject_id,
                'event_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArtwork2Table
        Schema::create('article_artwork', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'artwork');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\Artwork')->where('related_type', 'articles') as $pivot) { // Artwork::sidebarArticle()
            DB::table('article_artwork')->insert([
                'artwork_id'    =>  $pivot->subject_id,
                'article_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArtworkExperienceTable
        Schema::create('artwork_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('experience_id')->unsigned();
            $table->foreign('experience_id')->references('id')->on('experiences')->onDelete('cascade');
            $table->integer("artwork_id")->unsigned();
            $table->foreign("artwork_id")->references('id')->on('artworks')->onDelete('cascade');
            $table->index(["artwork_id", "experience_id"], 'artwork_experience_artwork_id_experience_id_idx');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\Artwork')->where('related_type', 'interactiveFeatures.experiences') as $pivot) { // Artwork::sidebarExperiences()
            DB::table('artwork_experience')->insert([
                'artwork_id'    =>  $pivot->subject_id,
                'experience_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }
        // CreateArtwork2Table
        Schema::create('artwork_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'artwork', 'video');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\Artwork')->where('related_type', 'videos') as $pivot) { // Artwork::videos()
            DB::table('artwork_video')->insert([
                'artwork_id'    =>  $pivot->subject_id,
                'video_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateExhibitionEventSidebarTable
        Schema::create('exhibition_event_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'event', 'exhibition');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'exhibitions')->where('related_type', 'events') as $pivot) { // Exhibition::sidebarEvent()
            DB::table('exhibition_event_sidebar')->insert([
                'exhibition_id'    =>  $pivot->subject_id,
                'event_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateArticleExhibitionTable2
        Schema::create('article_exhibition', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'article', 'exhibition');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'exhibitions')->where('related_type', 'articles') as $pivot) { // Exhibition::articles()
            DB::table('article_exhibition')->insert([
                'exhibition_id'    =>  $pivot->subject_id,
                'article_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateExhibitionVideoTable
        Schema::create('exhibition_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'exhibition', 'video');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'exhibitions')->where('related_type', 'videos') as $pivot) { // Exhibition::videos()
            DB::table('exhibition_video')->insert([
                'exhibition_id'    =>  $pivot->subject_id,
                'video_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // AddGenericPageRelated
        Schema::create('event_generic_page', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'generic_page', 'event');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\GenericPage')->where('related_type', 'events') as $pivot) { // GenericPage::events()
            DB::table('event_generic_page')->insert([
                'generic_page_id'    =>  $pivot->subject_id,
                'event_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // AddGenericPageRelated
        Schema::create('article_generic_page', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'generic_page', 'article');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'App\Models\GenericPage')->where('related_type', 'articles') as $pivot) { // GenericPage::articles()
            DB::table('article_generic_page')->insert([
                'generic_page_id'    =>  $pivot->subject_id,
                'article_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // RecreateArticleSelectionTable
        Schema::create('article_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'article', 'selection');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'selections')->where('related_type', 'articles') as $pivot) { // Selection::articles() form, but also visible via Article::selections()
            DB::table('article_selection')->insert([
                'selection_id'    =>  $pivot->subject_id,
                'article_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateEventSelectionSidebarTable
        Schema::create('event_selection_sidebar', function (Blueprint $table) {
            $table->increments('id');
            createDefaultRelationshipTableFields($table, 'event', 'selection');
            $table->integer('position')->unsigned()->index();
            $table->timestamps();
        });

        foreach ($pivots->where('subject_type', '=', 'selections')->where('related_type', 'events') as $pivot) { // Selection::sidebarEvent()
            DB::table('event_selection_sidebar')->insert([
                'selection_id'    =>  $pivot->subject_id,
                'event_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        // CreateSelectionVideoTable
        Schema::create('selection_video', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            createDefaultRelationshipTableFields($table, 'selection', 'video');
            $table->integer('position')->unsigned()->index();
        });

        foreach ($pivots->where('subject_type', '=', 'selections')->where('related_type', 'videos') as $pivot) { // Selection::videos()
            DB::table('selection_video')->insert([
                'selection_id'    =>  $pivot->subject_id,
                'video_id'    =>  $pivot->related_id,
                'position'      =>  $pivot->position,
            ]);
        }

        DB::table('related')->where('browser_name', 'sidebar_items')->delete();

        Schema::table('related', function (Blueprint $table) {
            $table->dropUnique('related_unique');
            $table->unique(
                ['subject_id', 'subject_type', 'related_id', 'related_type'],
                'related_unique'
            );
        });
    }
}

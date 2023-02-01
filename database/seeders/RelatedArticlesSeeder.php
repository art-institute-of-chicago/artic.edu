<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelatedArticlesSeeder extends Seeder
{
    public function run(): void
    {
        // WEB-1183: page_article_article missing here
        $artArticles = DB::table('article_article')->select('*')->get();
        $pageArticles = DB::table('article_page')->select('*')->get();
        $pageArtArticles = DB::table('page_art_article')->select('*')->get();
        $articleArtists = DB::table('article_artist')->select('*')->get();

        foreach ($artArticles as $article) {
            DB::table('related')->insert([
                'subject_id' => $article->article_id,
                'subject_type' => 'articles',
                'related_type' => 'articles',
                'related_id' => $article->related_article_id,
                'browser_name' => 'further_reading_items',
                'position' => $article->position,
            ]);
        }

        foreach ($pageArticles as $article) {
            DB::table('related')->insert([
                'subject_id' => $article->page_id,
                'subject_type' => 'App\Models\Page',
                'related_type' => 'articles',
                'related_id' => $article->article_id,
                'browser_name' => 'featured_items',
                'position' => $article->position,
            ]);
        }

        foreach ($pageArtArticles as $article) {
            DB::table('related')->insert([
                'subject_id' => $article->page_id,
                'subject_type' => 'App\Models\Page',
                'related_type' => 'articles',
                'related_id' => $article->article_id,
                'browser_name' => 'featured_items',
                'position' => $article->position,
            ]);
        }

        foreach ($articleArtists as $article) {
            DB::table('related')->insert([
                'subject_id' => $article->artist_id,
                'subject_type' => 'artists',
                'related_type' => 'articles',
                'related_id' => $article->article_id,
                'browser_name' => 'related_items',
                'position' => $article->position,
            ]);
        }

        DB::table('related')->where('related_type', 'digitalLabels')->delete();

        DB::table('related')->where('browser_name', 'sidebar_items')->delete();

        foreach (DB::table('api_relatables')
            ->where('relation', '=', 'exhibitions')
            ->where('api_relatable_type', '=', 'App\Models\GenericPage')
            ->get() as $pivot
        ) {
            DB::table('related')->insert([
                'subject_id' => $pivot->api_relatable_id,
                'subject_type' => 'App\Models\GenericPage',
                'related_type' => 'exhibitions',
                'related_id' => $pivot->api_relation_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
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
                    'subject_id' => $pivot->api_relatable_id,
                    'subject_type' => $type,
                    'related_type' => 'exhibitions',
                    'related_id' => $pivot->api_relation_id,
                    'browser_name' => 'sidebar_items',
                    'position' => $pivot->position,
                ]);
            }

            DB::table('api_relatables')
                ->where('relation', '=', 'sidebarExhibitions')
                ->where('api_relatable_type', '=', $type)
                ->delete();
        }

        foreach (DB::table('article_event_sidebar')->select('*')->get() as $pivot) { // Article::sidebarEvent()
            DB::table('related')->insert([
                'subject_id' => $pivot->article_id,
                'subject_type' => 'articles',
                'related_type' => 'events',
                'related_id' => $pivot->event_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_article_sidebar')->select('*')->get() as $pivot) { // Article::sidebarArticle()
            DB::table('related')->insert([
                'subject_id' => $pivot->article_id,
                'subject_type' => 'articles',
                'related_type' => 'articles',
                'related_id' => $pivot->related_article_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_video')->select('*')->get() as $pivot) { // Article::videos()
            DB::table('related')->insert([
                'subject_id' => $pivot->article_id,
                'subject_type' => 'articles',
                'related_type' => 'videos',
                'related_id' => $pivot->video_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_event')->select('*')->get() as $pivot) { // Artwork::sidebarEvent()
            DB::table('related')->insert([
                'subject_id' => $pivot->artwork_id,
                'subject_type' => 'App\Models\Artwork',
                'related_type' => 'events',
                'related_id' => $pivot->event_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_artwork')->select('*')->get() as $pivot) { // Artwork::sidebarArticle()
            DB::table('related')->insert([
                'subject_id' => $pivot->artwork_id,
                'subject_type' => 'App\Models\Artwork',
                'related_type' => 'articles',
                'related_id' => $pivot->article_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_experience')->select('*')->get() as $pivot) { // Artwork::sidebarExperiences()
            DB::table('related')->insert([
                'subject_id' => $pivot->artwork_id,
                'subject_type' => 'App\Models\Artwork',
                'related_type' => 'interactiveFeatures.experiences',
                'related_id' => $pivot->experience_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('artwork_video')->select('*')->get() as $pivot) { // Artwork::videos()
            DB::table('related')->insert([
                'subject_id' => $pivot->artwork_id,
                'subject_type' => 'App\Models\Artwork',
                'related_type' => 'videos',
                'related_id' => $pivot->video_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('exhibition_event_sidebar')->select('*')->get() as $pivot) { // Exhibition::sidebarEvent()
            DB::table('related')->insert([
                'subject_id' => $pivot->exhibition_id,
                'subject_type' => 'exhibitions',
                'related_type' => 'events',
                'related_id' => $pivot->event_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_exhibition')->select('*')->get() as $pivot) { // Exhibition::articles()
            DB::table('related')->insert([
                'subject_id' => $pivot->exhibition_id,
                'subject_type' => 'exhibitions',
                'related_type' => 'articles',
                'related_id' => $pivot->article_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('exhibition_video')->select('*')->get() as $pivot) { // Exhibition::videos()
            DB::table('related')->insert([
                'subject_id' => $pivot->exhibition_id,
                'subject_type' => 'exhibitions',
                'related_type' => 'videos',
                'related_id' => $pivot->video_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('event_generic_page')->select('*')->get() as $pivot) { // GenericPage::events()
            DB::table('related')->insert([
                'subject_id' => $pivot->generic_page_id,
                'subject_type' => 'App\Models\GenericPage',
                'related_type' => 'events',
                'related_id' => $pivot->event_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_generic_page')->select('*')->get() as $pivot) { // GenericPage::articles()
            DB::table('related')->insert([
                'subject_id' => $pivot->generic_page_id,
                'subject_type' => 'App\Models\GenericPage',
                'related_type' => 'articles',
                'related_id' => $pivot->article_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('article_selection')->select('*')->get() as $pivot) { // Selection::articles() form, but also visible via Article::selections()
            DB::table('related')->insert([
                'subject_id' => $pivot->selection_id,
                'subject_type' => 'selections',
                'related_type' => 'articles',
                'related_id' => $pivot->article_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('event_selection_sidebar')->select('*')->get() as $pivot) { // Selection::sidebarEvent()
            DB::table('related')->insert([
                'subject_id' => $pivot->selection_id,
                'subject_type' => 'selections',
                'related_type' => 'events',
                'related_id' => $pivot->event_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }

        foreach (DB::table('selection_video')->select('*')->get() as $pivot) { // Selection::videos()
            DB::table('related')->insert([
                'subject_id' => $pivot->selection_id,
                'subject_type' => 'selections',
                'related_type' => 'videos',
                'related_id' => $pivot->video_id,
                'browser_name' => 'sidebar_items',
                'position' => $pivot->position,
            ]);
        }
    }
}

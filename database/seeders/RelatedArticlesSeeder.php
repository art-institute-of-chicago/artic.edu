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
    }
}

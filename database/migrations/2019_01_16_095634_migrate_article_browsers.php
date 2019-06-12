<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateArticleBrowsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $artArticles = DB::table('article_article')->select('*')->get();
        $pageArticles = DB::table('article_page')->select('*')->get();
        $pageArtArticles = DB::table('page_art_article')->select('*')->get();

        foreach ($artArticles as $article) {
            DB::table('related')->insert([
                'subject_id'    =>  $article->article_id,
                'subject_type'  =>  'articles',
                'related_type'  =>  'articles',
                'related_id'    =>  $article->related_article_id,
                'browser_name'  =>  'further_reading_items',
                'position'      =>  $article->position,
            ]);
        }

        foreach ($pageArticles as $article) {
            DB::table('related')->insert([
                'subject_id'    =>  $article->page_id,
                'subject_type'  =>  'App\Models\Page',
                'related_type'  =>  'articles',
                'related_id'    =>  $article->article_id,
                'browser_name'  =>  'featured_items',
                'position'      =>  $article->position,
            ]);
        }

        foreach ($pageArtArticles as $article) {
            DB::table('related')->insert([
                'subject_id'    =>  $article->page_id,
                'subject_type'  =>  'App\Models\Page',
                'related_type'  =>  'articles',
                'related_id'    =>  $article->article_id,
                'browser_name'  =>  'featured_items',
                'position'      =>  $article->position,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

class RelatedArticlesTest extends BaseTestCase
{
    public function test_related_articles_exist()
    {
        $allArticlesCount = DB::table('article_article')->select('*')->count()
            + DB::table('article_page')->select('*')->count()
            + DB::table('page_art_article')->select('*')->count()
            + DB::table('article_artist')->select('*')->get();
        $this->assertDatabaseCount('related', $allArticlesCount);
    }
}

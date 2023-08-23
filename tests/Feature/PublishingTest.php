<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

class PublishingTest extends BaseTestCase
{
    public function test_published_articles_have_a_publish_start_date(): void
    {
        foreach (['articles', 'events', 'highlights'] as $table) {
            foreach (DB::table($table)->where('published', 1)->get() as $article) {
                $this->assertNotNull($article->publish_start_date);
            }
        }
    }
}

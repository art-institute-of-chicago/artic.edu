<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Event;
use App\Models\GenericPage;
use App\Models\LandingPage;
use Illuminate\Database\Seeder;

/**
 * Guarantees the CMS-managed pages that Percy snapshots (Home, one generic
 * page, one article and one event) exist with fixed, published content. Run
 * before starting the app server for a Percy build — see
 * .github/workflows/percy.yml.
 *
 * This is a minimal Home fixture (title + intro only). For a fuller Home
 * page with all its blocks, see the setup in tests/Feature/HomePageTest.php.
 */
class PercyFixtureSeeder extends Seeder
{
    /**
     * Article and event URLs are id-based (/articles/{id}, /events/{id}), so
     * these fixtures are pinned to fixed ids well above any real record's.
     * Keep in sync with tests-percy/fixtures.js.
     */
    public const ARTICLE_ID = 999001;
    public const EVENT_ID = 999001;

    public function run(): void
    {
        $homePage = LandingPage::firstOrNew(['type_id' => 1, 'title' => 'Home']);
        $homePage->published = true;
        $homePage->header_variation = 'default';
        $homePage->labels = [
            'home_intro' => '<p>Welcome to the Art Institute of Chicago.</p>',
            'home_location_label' => '111 S Michigan Ave',
            'home_location_link' => 'https://goo.gl/maps/rWJ5uyDiokKyETnw6',
            'home_buy_tix_label' => 'Buy Tickets',
            'home_buy_tix_link' => 'https://sales.artic.edu/admissions',
        ];
        $homePage->save();

        $genericPage = GenericPage::firstOrNew(['title' => 'Percy Fixture Page']);
        $genericPage->published = true;
        $genericPage->short_description = 'Fixture page used by Percy visual regression snapshots.';
        $genericPage->save();

        $this->seedArticle();
        $this->seedEvent();
    }

    private function seedArticle(): void
    {
        $article = Article::firstOrNew(['id' => self::ARTICLE_ID]);
        $article->forceFill([
            'id' => self::ARTICLE_ID,
            'published' => true,
            'title' => 'Percy Fixture Article',
            'date' => '2024-01-15',
            'author_display' => 'Percy Fixture Author',
            'heading' => '<p>Fixture article used by Percy visual regression snapshots.</p>',
            'list_description' => '<p>Fixture article used by Percy visual regression snapshots.</p>',
            'layout_type' => Article::BASIC,
            'is_unlisted' => true,
        ]);
        $article->save();
    }

    private function seedEvent(): void
    {
        $event = Event::firstOrNew(['id' => self::EVENT_ID]);
        $event->forceFill([
            'id' => self::EVENT_ID,
            'published' => true,
            'title' => 'Percy Fixture Event',
            'short_description' => 'Fixture event used by Percy visual regression snapshots.',
            'list_description' => 'Fixture event used by Percy visual regression snapshots.',
            'location' => 'Fullerton Hall',
            'is_private' => false,
            'is_free' => true,
            'is_ticketed' => false,
            'layout_type' => 0,
        ]);
        $event->save();

        // A single occurrence fixed in the past, with no date rules, keeps the
        // event non-recurring and its rendered dates independent of "today".
        $event->eventMetas()->delete();
        $event->eventMetas()->create([
            'date' => '2024-01-15 14:00:00',
            'date_end' => '2024-01-15 15:00:00',
        ]);
    }
}

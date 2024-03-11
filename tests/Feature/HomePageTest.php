<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Api\Exhibition;
use App\Models\Event;
use Tests\MockApi;

class HomePageTest extends BaseTestCase
{
    use MockApi;

    public function setUp(): void
    {
        parent::setUp();

        $homePage = \App\Models\LandingPage::firstOrNew(['type_id' => 1, 'title' => 'Home', 'published' => true]);

        $homePage->header_variation = 'default';
        $homePage->labels = [
            'home_intro' => '<p>Welcome to the Art Institute of Chicago, home to a <a href=\'\/collection\' rel=\'noopener noreferrer\'>collection of art<\/a> that spans centuries and the globe\u2014and one of Tripadvisor\u2019s \u201cBest of the Best\u201d US attractions of 2023. We look forward to <a href=\'\/visit\' rel=\'noopener noreferrer\'>your visit<\/a> and invite you to explore our many <a href=\'\/exhibitions\' rel=\'noopener noreferrer\'>exhibitions<\/a> and to join us for one of our <a href=\'\/events?type=6&amp;audience=3\' rel=\'noopener noreferrer\'>free daily tours<\/a>.<br class=\'softbreak\'><\/p>',
            'home_location_label' => '111 S Michigan Ave',
            'home_location_link' => 'https:\/\/goo.gl\/maps\/rWJ5uyDiokKyETnw6',
            'home_buy_tix_label' => 'Buy Tickets',
            'home_buy_tix_link' => 'https:\/\/sales.artic.edu\/admissions'
        ];
        $homePage->save();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'showcase',
            'position' => 1
        ]);
        $block->content = [
            'title' => '<p>Free Winter Weekdays<br class=\'softbreak\'><\/p>',
            'description' => '<p>Calling all Illinois residents! Enjoy free general museum admission every weekday (Mondays, Thursdays, and Fridays), January 8\u2013March 22, 2024.<br class=\'softbreak\'><\/p>',
            'link_url' => '\/visit\/free-admission-opportunities',
            'link_label' => 'Learn more',
            'media_type' => 'image'
        ];
        $block->save();

        $exhibitions = Exhibition::factory()->count(3)->make();
        foreach ($exhibitions as $exhibition) {
            $this->addMockApiResponses([
                $this->mockApiModelReponse($exhibition),
            ]);
        }

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'feature_block',
            'position' => 2
        ]);
        $block->content = [
            'image_ratio' => 'square',
            'feature_heading' => 'Exhibitions',
            'browse_link' => '\/exhibitions',
            'feature_type' => 'exhibitions',
            'columns' => 3,
            'override_exhibition' => true,
            'browse_label' => 'See all current exhibitions',
            'browsers' => ['exhibitions' => $exhibitions->pluck('id')]
        ];
        $block->save();

        $events = Event::factory()
            ->count(14)
            ->create();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'feature_block',
            'position' => 3
        ]);
        $block->content = [
            'feature_heading' => 'Events',
            'browse_link' => '\/events',
            'feature_type' => 'events',
            'image_ratio' => 'landscape',
            'override_event' => true,
            'browse_label' => 'See all upcoming events',
            'browsers' => ['events' => $events->pluck('id')]
        ];
        $block->save();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'custom_banner',
            'position' => 4
        ]);
        $block->content = [
            'background_type' => 'background_image',
            'heading' => 'Join our Community',
            'body' => '<p>The best way to lend your support is to become a member.<br class=\'softbreak\'><\/p>',
            'button_type' => 'custom',
            'button_text' => 'Become a Member',
            'button_url' => 'https:\/\/sales.artic.edu\/memberships',
            'title' => 'Join our Community'
        ];
        $block->save();

        $artworks = \App\Models\Api\Artwork::factory()
            ->count(20)
            ->create();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'collection_block',
            'position' => 5
        ]);
        $block->content = [
            'bottom_desc' => '<p>Explore thousands of artworks in the museum\u2019s collection\u2014from our renowned icons to lesser-known works from every corner of the globe.<br class=\'softbreak\'><\/p>',
            'secondary_button_link' => 'https:\/\/sales.artic.edu\/admissions',
            'primary_button_link' => '\/collection',
            'collection_heading' => 'The Collection',
            'primary_button_label' => 'Explore the Collection',
            'secondary_button_label' => 'Buy Tickets',
            'browsers' => ['artworks' => $artworks->pluck('id')]
        ];
        $block->save();

        $articles = \App\Models\Article::factory()
            ->count(5)
            ->published()
            ->create();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'stories_block',
            'position' => 6
        ]);
        $block->content = [
            'stories_heading' => 'Articles & Videos',
            'browse_label' => 'See more',
            'browse_link' => '\/articles_publications',
            'browsers' => ['content' => $articles->pluck('id')]
        ];
        $block->save();

        $block = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $homePage->id,
            'blockable_type' => 'landingPages',
            'type' => 'custom_banner',
            'position' => 7
        ]);
        $block->content = [
            'body' => '<p>From books and notecards to jewelry and home decor, we have something for every art lover.<br class=\'softbreak\'><\/p>',
            'button_type' => 'custom',
            'heading' => 'Museum Shop',
            'background_type' => 'background_image',
            'button_url' => 'https:\/\/shop.artic.edu\/',
            'button_text' => 'Explore the Shop',
            'title' => 'Museum Shop'
        ];
        $block->save();
    }

    public function test_home_page_loads(): void
    {
        $this->addMockApiResponses([
            $this->mockApiSearchResponse(), // Exhibitions
        ]);

        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_visit_page_links_appear_on_home_page(): void
    {
        $response = $this->get(route('home'));
        $response->assertSee('We look forward to');
    }
}

<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class VisitPageTest extends BaseTestCase
{
    public $appUrl;

    public function setUp(): void
    {
        parent::setUp();
        $this->appUrl = config('APP_URL');

        $visitPage = \App\Models\LandingPage::firstOrNew(['type_id' => 4, 'title' => 'Visit', 'published' => true]);

        $visitPage->header_variation = 'default';
        $visitPage->labels = [
            'visit_nav_buy_tix_label' => 'Buy Tickets',
            'visit_nav_buy_tix_link' => 'https:\/\/sales.artic.edu\/admissions',
            'visit_members_intro' => '<p>Members: The first hour of every day, 10\u201311 a.m., is reserved for member-only viewing.<\/p>',
            'visit_admission_intro' => '<p><strong>Free Admission Opportunities:<\/strong> The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, as well as to Illinois residents on certain days throughout the year. <a href=\'\/visit\/free-admission\' rel=\'noopener noreferrer\'>Learn more<\/a>.<\/p><p>Members never need tickets and never have to wait in admission lines.<\/p>',
            'visit_admission_tix_label' => 'Buy Tickets',
            'visit_admission_tix_link' => 'https:\/\/sales.artic.edu\/admissions',
            'visit_admission_members_label' => 'Become a Member',
            'visit_admission_members_link' => 'https:\/\/sales.artic.edu\/memberships',
            'visit_parking_label' => 'Transit & Parking',
            'visit_parking_link' => '\/directions-and-parking',
            'visit_faqs_label' => 'More FAQs',
            'visit_faqs_link' => 'https:\/\/www.artic.edu\/visit\/frequently-asked-questions',
            'visit_faq_more_link' => 'https:\/\/www.artic.edu\/visit\/frequently-asked-questions',
        ];
        $visitPage->save();

        $showcase = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'showcase',
            'position' => 1
        ]);
        $showcase->content = [
            'link_label' => 'Learn more',
            'link_url' => '\/exhibitions\/10095\/picasso-drawing-from-life',
            'tag' => 'Special Ticketed Exhibition',
            'description' => '<p>More than 60 of Picasso\u2019s works on paper offer the chance to peer into his life and meet the fellow artists, friends, family members, lovers, and dealers whose support made his enormous success possible.<\/p><p><br><\/p><p>Please note that this exhibition requires a $5 ticket in addition general admission.<\/p>',
            'title' => '<p>Don\u2019t Miss This Show<\/p>'
        ];
        $showcase->save();

        $grid = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid',
            'position' => 2
        ]);
        $grid->content = [
            'grid_title' => '<p>Plan Your Visit<\/p>',
            'heading' => '<p>Plan Your Visit<br class=\'softbreak\'><\/p>'
        ];
        $grid->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 1,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'description' => '<p>Take a look at our museum floor plan to get a sense of the museum\'s layout and mark any must-see spaces.<\/p>',
            'title' => '<p>Museum Map<\/p>',
            'url' => '\/visit\/explore-on-your-own\/museum-floor-plan',
            'label_position' => 'description',
            'label' => 'Get oriented'
        ];
        $gridItem->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 2,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'title' => '<p>Free Daily Tours<\/p>',
            'description' => '<p>Follow a knowledgeable guide through the galleries on a free tour, offered in English every day at 1:00 and 3:00 and in Spanish on Fridays and Saturdays at 2:00.<\/p>',
            'url' => '\/events?type=6&audience=3',
            'label' => 'See starting locations',
            'label_position' => 'description'
        ];
        $gridItem->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 3,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'url' => '\/highlights\/3\/what-to-see-in-an-hour',
            'label' => 'Tour on your own',
            'description' => '<p>Experience some of the museum\u2019s most iconic works by accessing self-guided tours, like What to See in an Hour, on your phone.<\/p>',
            'title' => '<p>What to See in an Hour<\/p>',
            'label_position' => 'description'
        ];
        $gridItem->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 4,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'title' => '<p>Ryan Learning Center<\/p>',
            'label_position' => 'description',
            'label' => 'Get creative',
            'description' => '<p>Enjoy creative activities in this space, Thursdays\u2013Mondays, 11:00\u20133:00, including making a custom museum tour with JourneyMaker.<\/p>',
            'url' => '\/ryan-learning-center'
        ];
        $gridItem->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 5,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'title' => '<p>Dining and Shopping<\/p>',
            'url' => '\/visit\/dining-and-shopping',
            'label' => 'View options',
            'label_position' => 'description',
            'description' => '<p>Grab a bite at one of our caf\u00e9s and be sure to pick up a souvenir of your visit at one of two store locations.<\/p>'
        ];
        $gridItem->save();

        $gridItem = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'grid_item',
            'position' => 6,
            'parent_id' => $grid->id,
            'child_key' => 'grid_item',
        ]);
        $gridItem->content = [
            'title' => '<p>Accessibility<\/p>',
            'description' => '<p>The Art Institute offers a range of resources and programs designed for adults and children with disabilities.<\/p>',
            'label_position' => 'description',
            'label' => 'Learn more',
            'url' => '/visit/accessibility'
        ];
        $gridItem->save();

        $customBanner = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'custom_banner',
            'position' => 3
        ]);
        $customBanner->content = [
            'button_type' => 'mobile_app',
            'background_type' => 'background_image',
            'title' => 'Get the App',
            'body' => '<p>Hear the stories behind the art\u2014straight from artists, experts, and community members.<br class=\'softbreak\'><\/p>'
        ];
        $customBanner->save();

        $genericPages = \App\Models\GenericPage::factory()
            ->count(8)
            ->published()
            ->create();

        $featuredPagesGrid = \App\Models\Vendor\Block::firstOrNew([
            'blockable_id' => $visitPage->id,
            'blockable_type' => 'landingPages',
            'type' => 'featured_pages_grid',
            'position' => 4
        ]);
        $featuredPagesGrid->content = [
            'grid_heading' => 'Who\'s Visiting',
            'heading' => 'Who\'s Visiting?',
            'browsers' => [
                'genericPages' => $genericPages->pluck('id')
            ]
        ];
        $featuredPagesGrid->save();
    }

    public function test_visiting_hours_are_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'Members: The first hour of every day, 10\u201311 a.m., is reserved for member-only viewing.',
            false
        );
    }

    public function test_admission_description_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, as well as to Illinois residents on certain days throughout the year.'
        );
    }

    public function test_accessibility_link_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute offers a range of resources and programs designed for adults and children with disabilities.'
        );
        $response->assertSee('Learn more');
        $response->assertSee("href=\"{$this->appUrl}/visit/accessibility\"", false);
    }

    public function test_family_pages_titles_are_displayed_in_order(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSeeInOrder([
            'Museum Map',
            'What to See in an Hour',
            'Ryan Learning Center',
        ]);
    }
}

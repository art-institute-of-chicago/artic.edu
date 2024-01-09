<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class VisitPageTest extends BaseTestCase
{
    public $appUrl;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();
        $this->appUrl = config('APP_URL');
    }

    public function test_visiting_hours_are_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute reopens on July 30, and we&#8217;re so happy to welcome you back to our galleries. Please see below for new hours—including member-only hours—and updated safety policies.',
            false
        );
        $response->assertSee("Member-Only Hours");
        $response->assertSee('Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Sunday 10-11 a.m.', false);
    }

    public function test_admission_description_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents on certain days throughout the year.'
        );
    }

    public function test_accessibility_link_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute of Chicago welcomes all visitors and is committed to making its services accessible to everyone. We offer a range of resources for both adults and children with disabilities.'
        );
        $response->assertSee('Learn more about accessibility');
        $response->assertSee("href=\"{$this->appUrl}/visit/accessibility/visitors-with-mobility-needs\"", false);
    }

    public function test_family_pages_titles_are_displayed_in_order(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSeeInOrder([
            'Art Institute Mobile App',
            'What to See in an Hour',
            'Visit Us Virtually',
        ]);
    }

    public function test_mobile_app_family_page_link_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee(
            'The Art Institute&#8217;s free app offers the stories behind the art through conversations with artists, experts, and community members. Download it via the App Store or Google Play.',
            false
        );
        $response->assertSee('Learn more');
        $response->assertSee("href=\"{$this->appUrl}/visit/explore-on-your-own/mobile-app-audio-tours\"", false);
    }

    public function test_highlights_family_page_link_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee('Short on time? Check out this must-see guide to the collection.');
        $response->assertSee('More custom tours');
        $response->assertSee("href=\"{$this->appUrl}/highlights\"", false);
    }

    public function test_visit_virtually_family_page_link_is_displayed(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSee('Even from afar, there&#8217;s a host of ways to connect to our collection of art from around the world&mdash;whether you&#8217;re seeking inspiration, community, or a little adventure.', false);
        $response->assertSee('Learn more');
        $response->assertSee("href=\"{$this->appUrl}/visit-us-virtually\"", false);
    }

    public function test_what_to_expect_items_are_displayed_in_order(): void
    {
        $response = $this->get(route('visit'));
        $response->assertSeeInOrder([
            'Face coverings will be required for your entire museum visit.',
            'Maintain a physical distance of six-feet from staff and visitors.',
            'Advance ticket purchase is required. Members will be required to display digital member card using the Art Institute of Chicago mobile app.',
            'Anyone feeling unwell should postpone their visit for another time.',
            'Our checkrooms are currently closed. Pack light, and remember some items are not allowed in the galleries.',
            'Our amenities are temporarily limited. Service and spaces currently unavailable include restaurants, auditoria, valet service, and the Member Lounge.',
            'Some galleries may have limited capacity or be temporarily closed.',
            'Be mindful to abide by directional signage, including designated entrances and exits.',
            'Special exhibitions may use timed queueing systems. Check in at exhibition entrances to reserve your spot in line.',
        ]);
    }
}

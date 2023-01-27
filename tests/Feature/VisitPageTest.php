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

    public function test_visiting_hours_are_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSeeText(
            "The Art Institute reopens on July 30, and we're so happy to welcome you back to our galleries. Please see below for new hours—including member-only hours—and updated safety policies."
        );
        $response->assertSeeText("Member-Only Hours");
        $response->assertSee('<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Friday 12-1 p.m.<br/>Saturday&ndash;Sunday 10&ndash;11 a.m.</p>');
    }

    public function test_admission_description_is_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSee(
            '<p>The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents on certain days throughout the year. <a href="/visit/free-admission" target="_blank">Learn more<span class="sr-only"> about free access</span></a>.</p>'
        );
    }

    public function test_accessibility_link_is_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSeeText(
            'The Art Institute of Chicago welcomes all visitors and is committed to making its services accessible to everyone. We offer a range of resources for both adults and children with disabilities.'
        );
        $response->assertSeeText('Learn more about accessibility');
        $response->assertSee("href='{$this->appUrl}/visit/accessibility/visitors-with-mobility-needs'");
    }

    public function test_family_pages_titles_are_displayed_in_order()
    {
        $response = $this->get('/visit');
        $response->assertSeeInOrder([
            'Art Institute Mobile App',
            'What to See in an Hour',
            'Visit Us Virtually',
        ]);
    }

    public function test_mobile_app_family_page_link_is_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSeeText(
            "The Art Institute\'s free app offers the stories behind the art through conversations with artists, experts, and community members. Download it via the App Store or Google Play."
        );
        $response->assertSeeText('Learn more');
        $response->assertSee("href='{$this->appUrl}/visit/explore-on-your-own/mobile-app-audio-tours'");
    }

    public function test_highlights_family_page_link_is_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSeeText('Short on time? Check out this must-see guide to the collection.');
        $response->assertSeeText('More custom tours');
        $response->assertSee("href='{$this->appUrl}/highlights'");
    }

    public function test_visit_virtually_family_page_link_is_displayed()
    {
        $response = $this->get('/visit');
        $response->assertSeeText( 'Even from afar, there\'s a host of ways to connect to our collection of art from around the world&mdash;whether you\'re seeking inspiration, community, or a little adventure.');
        $response->assertSeeText('Learn more');
        $response->assertSee("href='{$this->appUrl}/visit-us-virtually'");
    }
}

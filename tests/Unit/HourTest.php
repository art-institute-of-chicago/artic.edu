<?php

namespace Tests\Unit;

use App\Models\Hour;
use Carbon\Carbon;
use Tests\TestCase;

class HourTest extends TestCase
{
    private $hour;
    private $hourAllClosed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hour = Hour::factory()->make([
            'monday_is_closed' => false,
            'monday_member_open' => new \DateInterval('PT10H00M'),
            'monday_member_close' => new \DateInterval('PT11H00M'),
            'monday_public_open' => new \DateInterval('PT11H00M'),
            'monday_public_close' => new \DateInterval('PT17H00M'),
            'tuesday_is_closed' => true,
            'wednesday_is_closed' => true,
            'thursday_is_closed' => false,
            'thursday_member_open' => new \DateInterval('PT10H00M'),
            'thursday_member_close' => new \DateInterval('PT11H00M'),
            'thursday_public_open' => new \DateInterval('PT11H00M'),
            'thursday_public_close' => new \DateInterval('PT17H00M'),
            'friday_is_closed' => false,
            'friday_member_open' => new \DateInterval('PT10H00M'),
            'friday_member_close' => new \DateInterval('PT11H00M'),
            'friday_public_open' => new \DateInterval('PT11H00M'),
            'friday_public_close' => new \DateInterval('PT17H00M'),
            'saturday_is_closed' => false,
            'saturday_member_open' => new \DateInterval('PT10H00M'),
            'saturday_member_close' => new \DateInterval('PT11H00M'),
            'saturday_public_open' => new \DateInterval('PT11H00M'),
            'saturday_public_close' => new \DateInterval('PT17H00M'),
            'sunday_is_closed' => false,
            'sunday_member_open' => new \DateInterval('PT10H00M'),
            'sunday_member_close' => new \DateInterval('PT11H00M'),
            'sunday_public_open' => new \DateInterval('PT11H00M'),
            'sunday_public_close' => new \DateInterval('PT17H00M'),
        ]);

        $this->hourAllClosed = Hour::factory()->make([
            'monday_is_closed' => true,
            'tuesday_is_closed' => true,
            'wednesday_is_closed' => true,
            'thursday_is_closed' => true,
            'friday_is_closed' => true,
            'saturday_is_closed' => true,
            'sunday_is_closed' => true,
        ]);

        $this->hourEdgeCases = Hour::factory()->make([
            'monday_is_closed' => false,
            'monday_member_open' => null,
            'monday_member_close' => null,
            'monday_public_open' => null,
            'monday_public_close' => null,
            'tuesday_is_closed' => false,
            'tuesday_member_open' => null,
            'tuesday_member_close' => null,
            'tuesday_public_open' => new \DateInterval('PT11H00M'),
            'tuesday_public_close' => new \DateInterval('PT17H00M'),
            'wednesday_is_closed' => false,
            'wednesday_member_open' => null,
            'wednesday_member_close' => null,
            'wednesday_public_open' => null,
            'wednesday_public_close' => new \DateInterval('PT17H00M'),
            'thursday_is_closed' => false,
            'thursday_member_open' => null,
            'thursday_member_close' => null,
            'thursday_public_open' => new \DateInterval('PT17H00M'),
            'thursday_public_close' => null,
        ]);
    }

    private function getStatusHeader($hour = null, $isMobile = false)
    {
        return ($hour ?? $this->hour)->present()->getStatusHeader(null, $isMobile);
    }

    private function getHoursHeader($hour = null)
    {
        return ($hour ?? $this->hour)->present()->getHoursHeader();
    }

    /** @test */
    public function it_displays_before_member_open_hour()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader());
        $this->assertEquals('10–11 members | 11–5 public', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_before_member_open_hour_on_mobile()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Today', $this->getStatusHeader(null, true));
        $this->assertEquals('10–11 members | 11–5 public', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_during_member_open_hour()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 10, 30, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader());
        $this->assertEquals('10–11 members | 11–5 public', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_during_member_open_hour_on_mobile()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 10, 30, 0, 'America/Chicago'));
        $this->assertEquals('Today', $this->getStatusHeader(null, true));
        $this->assertEquals('10–11 members | 11–5 public', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_during_public_open_hours()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 12, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today until 5', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_after_public_close_hour_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 20, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed now. Next open Thursday.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_after_public_close_hour_before_an_open_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 3, 20, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed now. Next open tomorrow.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_a_closed_day_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 1, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed today. Next open Thursday.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_a_closed_day_before_an_open_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed today. Next open tomorrow.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_when_closed_all_days()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed today.', $this->getStatusHeader($this->hourAllClosed));
        $this->assertEquals(null, $this->getHoursHeader($this->hourAllClosed));
    }

    /** @test */
    public function it_displays_when_all_hours_are_missing()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals(null, $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_when_member_hours_are_missing()
    {
        $this->travelTo(Carbon::create(2022, 3, 1, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals('11–5', $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_when_public_open_is_missing()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals(null, $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_when_public_close_is_missing()
    {
        $this->travelTo(Carbon::create(2022, 3, 3, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals(null, $this->getHoursHeader($this->hourEdgeCases));
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;

use Carbon\Carbon;

use App\Models\Hour;

class HourTest extends TestCase
{
    private $hour;
    private $hourAllClosed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hour = Hour::factory()->make([
            'title' => 'Hours',
            'published' => true,
            'valid_from' => Carbon::now()->subWeek()->getTimestamp(),
            'valid_through' => Carbon::now()->addWeek()->getTimestamp(),
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
            'title' => 'Hours all closed',
            'published' => true,
            'valid_from' => Carbon::now()->subWeek()->getTimestamp(),
            'valid_through' => Carbon::now()->addWeek()->getTimestamp(),
            'monday_is_closed' => true,
            'tuesday_is_closed' => true,
            'wednesday_is_closed' => true,
            'thursday_is_closed' => true,
            'friday_is_closed' => true,
            'saturday_is_closed' => true,
            'sunday_is_closed' => true,
        ]);
    }

    /** @test */
    public function it_displays_before_member_open_hour()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Open today 10&ndash;11 members | 11&ndash;5 public',
            $this->hour->present()->display()
        );

    }

    /** @test */
    public function it_displays_before_member_open_hour_on_mobile()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Today 10&ndash;11 members | 11&ndash;5 public',
            $this->hour->present()->display(true)
        );

    }

    /** @test */
    public function it_displays_during_open_hours()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 12, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Open today until 5',
            $this->hour->present()->display()
        );

    }

    /** @test */
    public function it_displays_after_public_close_hour_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 20, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Closed now. Next open Thursday.',
            $this->hour->present()->display()
        );

    }

    /** @test */
    public function it_displays_a_closed_day_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 1, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Closed today. Next open Thursday.',
            $this->hour->present()->display()
        );

    }

    /** @test */
    public function it_displays_a_closed_day_before_an_open_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Closed today. Next open tomorrow.',
            $this->hour->present()->display()
        );

    }

    /** @test */
    public function it_displays_when_closed_all_days()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            'Closed today.',
            $this->hourAllClosed->present()->display()
        );

    }

}

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

        $this->hour = Hour::factory()->make();
        $this->hour->title = 'Hours';
        $this->hour->published = true;
        $this->hour->valid_from = Carbon::now()->subWeek()->getTimestamp();
        $this->hour->valid_through = Carbon::now()->addWeek()->getTimestamp();
        $this->hour->monday_is_closed = false;
        $this->hour->monday_member_open = new \DateInterval('PT10H00M');
        $this->hour->monday_member_close = new \DateInterval('PT11H00M');
        $this->hour->monday_public_open = new \DateInterval('PT11H00M');
        $this->hour->monday_public_close = new \DateInterval('PT17H00M');
        $this->hour->tuesday_is_closed = true;
        $this->hour->wednesday_is_closed = true;
        $this->hour->thursday_is_closed = false;
        $this->hour->thursday_member_open = new \DateInterval('PT10H00M');
        $this->hour->thursday_member_close = new \DateInterval('PT11H00M');
        $this->hour->thursday_public_open = new \DateInterval('PT11H00M');
        $this->hour->thursday_public_close = new \DateInterval('PT17H00M');
        $this->hour->friday_is_closed = false;
        $this->hour->friday_member_open = new \DateInterval('PT10H00M');
        $this->hour->friday_member_close = new \DateInterval('PT11H00M');
        $this->hour->friday_public_open = new \DateInterval('PT11H00M');
        $this->hour->friday_public_close = new \DateInterval('PT17H00M');
        $this->hour->saturday_is_closed = false;
        $this->hour->saturday_member_open = new \DateInterval('PT10H00M');
        $this->hour->saturday_member_close = new \DateInterval('PT11H00M');
        $this->hour->saturday_public_open = new \DateInterval('PT11H00M');
        $this->hour->saturday_public_close = new \DateInterval('PT17H00M');
        $this->hour->sunday_is_closed = false;
        $this->hour->sunday_member_open = new \DateInterval('PT10H00M');
        $this->hour->sunday_member_close = new \DateInterval('PT11H00M');
        $this->hour->sunday_public_open = new \DateInterval('PT11H00M');
        $this->hour->sunday_public_close = new \DateInterval('PT17H00M');

        $this->hourAllClosed = Hour::factory()->make();
        $this->hourAllClosed->title = 'Hours all closed';
        $this->hourAllClosed->published = true;
        $this->hourAllClosed->valid_from = Carbon::now()->subWeek()->getTimestamp();
        $this->hourAllClosed->valid_through = Carbon::now()->addWeek()->getTimestamp();
        $this->hourAllClosed->monday_is_closed = true;
        $this->hourAllClosed->tuesday_is_closed = true;
        $this->hourAllClosed->wednesday_is_closed = true;
        $this->hourAllClosed->thursday_is_closed = true;
        $this->hourAllClosed->friday_is_closed = true;
        $this->hourAllClosed->saturday_is_closed = true;
        $this->hourAllClosed->sunday_is_closed = true;
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

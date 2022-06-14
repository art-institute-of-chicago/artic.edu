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
            'monday_member_open' => 'PT10H00M',
            'monday_member_close' => 'PT11H00M',
            'monday_public_open' => 'PT11H00M',
            'monday_public_close' => 'PT17H00M',
            'tuesday_is_closed' => true,
            'wednesday_is_closed' => true,
            'thursday_is_closed' => false,
            'thursday_member_open' => 'PT10H00M',
            'thursday_member_close' => 'PT11H00M',
            'thursday_public_open' => 'PT11H00M',
            'thursday_public_close' => 'PT17H00M',
            'friday_is_closed' => false,
            'friday_member_open' => 'PT10H00M',
            'friday_member_close' => 'PT11H00M',
            'friday_public_open' => 'PT11H00M',
            'friday_public_close' => 'PT17H00M',
            'saturday_is_closed' => false,
            'saturday_member_open' => 'PT10H00M',
            'saturday_member_close' => 'PT11H00M',
            'saturday_public_open' => 'PT11H00M',
            'saturday_public_close' => 'PT17H00M',
            'sunday_is_closed' => false,
            'sunday_member_open' => 'PT10H00M',
            'sunday_member_close' => 'PT11H00M',
            'sunday_public_open' => 'PT11H00M',
            'sunday_public_close' => 'PT17H00M',
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
            'tuesday_public_open' => 'PT11H00M',
            'tuesday_public_close' => 'PT17H00M',
            'wednesday_is_closed' => false,
            'wednesday_member_open' => null,
            'wednesday_member_close' => null,
            'wednesday_public_open' => null,
            'wednesday_public_close' => 'PT17H00M',
            'thursday_is_closed' => false,
            'thursday_member_open' => null,
            'thursday_member_close' => null,
            'thursday_public_open' => 'PT11H00M',
            'thursday_public_close' => null,
            'friday_is_closed' => false,
            'friday_member_open' => 'PT10H15M',
            'friday_member_close' => 'PT10H45M',
            'friday_public_open' => 'PT10H45M',
            'friday_public_close' => 'PT17H15M',
            'saturday_is_closed' => false,
            'saturday_member_open' => null,
            'saturday_member_close' => null,
            'saturday_public_open' => 'PT11H15M',
            'saturday_public_close' => 'PT17H45M',
            'sunday_is_closed' => null,
            'sunday_member_open' => null,
            'sunday_member_close' => null,
            'sunday_public_open' => null,
            'sunday_public_close' => null,
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

    private function getHoursTableForHeader($hour = null)
    {
        return ($hour ?? $this->hour)->present()->getHoursTableForHeader();
    }

    private function getHoursTableForVisit($hour = null)
    {
        return ($hour ?? $this->hour)->present()->getHoursTableForVisit();
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
        $this->assertEquals('Open today', $this->getStatusHeader());
        $this->assertEquals('11–5', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_during_public_open_hours_on_mobile()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 12, 0, 0, 'America/Chicago'));
        $this->assertEquals('Today', $this->getStatusHeader(null, true));
        $this->assertEquals('11–5', $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_after_public_close_hour_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 20, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed now, next open Thursday.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_after_public_close_hour_before_an_open_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 3, 20, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed now, next open tomorrow.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_a_closed_day_before_a_closed_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 1, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed today, next open Thursday.', $this->getStatusHeader());
        $this->assertEquals(null, $this->getHoursHeader());
    }

    /** @test */
    public function it_displays_a_closed_day_before_an_open_day()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Closed today, next open tomorrow.', $this->getStatusHeader());
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

    /** @test */
    public function it_displays_with_minutes()
    {
        $this->travelTo(Carbon::create(2022, 3, 4, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals(
            '10:15–10:45 members | 10:45–5:15 public',
            $this->getHoursHeader($this->hourEdgeCases)
        );
    }

    /** @test */
    public function it_displays_when_member_hours_are_missing_with_minutes()
    {
        $this->travelTo(Carbon::create(2022, 3, 5, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals('11:15–5:45', $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_during_public_open_hours_with_minutes()
    {
        $this->travelTo(Carbon::create(2022, 3, 5, 12, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals('11:15–5:45', $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_when_all_fields_are_missing()
    {
        $this->travelTo(Carbon::create(2022, 3, 6, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals('Open today', $this->getStatusHeader($this->hourEdgeCases));
        $this->assertEquals(null, $this->getHoursHeader($this->hourEdgeCases));
    }

    /** @test */
    public function it_displays_hours_table_for_header()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Mon',
                    'end' => 'Mon',
                    'hours' => '11–5',
                    'days' => 'Mon',
                ],
                [
                    'start' => 'Tue',
                    'end' => 'Wed',
                    'hours' => 'Closed',
                    'days' => 'Tue–Wed',
                ],
                [
                    'start' => 'Thu',
                    'end' => 'Sun',
                    'hours' => '11–5',
                    'days' => 'Thu–Sun',
                ]
            ],
            $this->getHoursTableForHeader(),
        );
    }

    /** @test */
    public function it_displays_hours_table_for_header_when_closed_all_days()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Mon',
                    'end' => 'Sun',
                    'hours' => 'Closed',
                    'days' => 'Mon–Sun',
                ],
            ],
            $this->getHoursTableForHeader($this->hourAllClosed),
        );
    }

    /** @test */
    public function it_displays_hours_table_for_header_with_edge_cases()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Mon',
                    'end' => 'Mon',
                    'hours' => 'Open',
                    'days' => 'Mon',
                ],
                [
                    'start' => 'Tue',
                    'end' => 'Tue',
                    'hours' => '11–5',
                    'days' => 'Tue',
                ],
                [
                    'start' => 'Wed',
                    'end' => 'Thu',
                    'hours' => 'Open',
                    'days' => 'Wed–Thu',
                ],
                [
                    'start' => 'Fri',
                    'end' => 'Fri',
                    'hours' => '10:45–5:15',
                    'days' => 'Fri',
                ],
                [
                    'start' => 'Sat',
                    'end' => 'Sat',
                    'hours' => '11:15–5:45',
                    'days' => 'Sat',
                ],
                [
                    'start' => 'Sun',
                    'end' => 'Sun',
                    'hours' => 'Open',
                    'days' => 'Sun',
                ],
            ],
            $this->getHoursTableForHeader($this->hourEdgeCases),
        );
    }

    /** @test */
    public function it_displays_hours_table_for_visit()
    {
        $this->travelTo(Carbon::create(2022, 2, 28, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Mon',
                    'end' => 'Mon',
                    'hours' => '11–5',
                    'days' => 'Mon',
                ],
                [
                    'start' => 'Tue',
                    'end' => 'Wed',
                    'hours' => 'Closed',
                    'days' => 'Tue–Wed',
                ],
                [
                    'start' => 'Thu',
                    'end' => 'Sun',
                    'hours' => '11–5',
                    'days' => 'Thu–Sun',
                ]
            ],
            $this->getHoursTableForHeader(),
        );
    }

    /** @test */
    public function it_displays_hours_table_for_visit_when_closed_all_days()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Monday',
                    'end' => 'Sunday',
                    'member_hours' => 'Closed',
                    'public_hours' => 'Closed',
                    'days' => 'Monday–Sunday',
                ],
            ],
            $this->getHoursTableForVisit($this->hourAllClosed),
        );
    }

    /** @test */
    public function it_displays_hours_table_for_visit_with_edge_cases()
    {
        $this->travelTo(Carbon::create(2022, 3, 2, 6, 0, 0, 'America/Chicago'));
        $this->assertEquals(
            [
                [
                    'start' => 'Monday',
                    'end' => 'Monday',
                    'member_hours' => null,
                    'public_hours' => 'Open',
                    'days' => 'Monday',
                ],
                [
                    'start' => 'Tuesday',
                    'end' => 'Tuesday',
                    'member_hours' => null,
                    'public_hours' => '11 a.m.–5 p.m.',
                    'days' => 'Tuesday',
                ],
                [
                    'start' => 'Wednesday',
                    'end' => 'Wednesday',
                    'member_hours' => null,
                    'public_hours' => 'Closes at 5 p.m.',
                    'days' => 'Wednesday',
                ],
                [
                    'start' => 'Thursday',
                    'end' => 'Thursday',
                    'member_hours' => null,
                    'public_hours' => 'Opens at 11 a.m.',
                    'days' => 'Thursday',
                ],
                [
                    'start' => 'Friday',
                    'end' => 'Friday',
                    'member_hours' => '10:15–10:45 a.m.',
                    'public_hours' => '10:45 a.m.–5:15 p.m.',
                    'days' => 'Friday',
                ],
                [
                    'start' => 'Saturday',
                    'end' => 'Saturday',
                    'member_hours' => null,
                    'public_hours' => '11:15 a.m.–5:45 p.m.',
                    'days' => 'Saturday',
                ],
                [
                    'start' => 'Sunday',
                    'end' => 'Sunday',
                    'member_hours' => null,
                    'public_hours' => 'Open',
                    'days' => 'Sunday',
                ],
            ],
            $this->getHoursTableForVisit($this->hourEdgeCases),
        );
    }
}

<?php

namespace App\Presenters;

use App\Models\Hour;
use DateInterval;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;

class HoursPresenter extends BasePresenter
{
    public function validFrom()
    {
        if ($this->entity->valid_from) {
            return $this->entity->valid_from->format('M j, Y');
        }
    }

    public function validThrough()
    {
        if ($this->entity->valid_through) {
            return $this->entity->valid_through->format('M j, Y');
        }
    }

    public function type()
    {
        return Hour::$types[$this->entity->type];
    }

    public function getStatusHeader($when = null, $isMobile = false)
    {
        $when = $when ?? now();

        if ($this->isMuseumClosedToday($when)) {
            return $this->getNextOpen($when, 'Closed today');
        }

        if ($this->isAfterPublicClose($when)) {
            return $this->getNextOpen($when, 'Closed now');
        }

        return $isMobile ? 'Today' : 'Open today';
    }

    public function getHoursHeader($when = null)
    {
        $when = $when ?? now();

        if ($this->isMuseumClosedToday($when)) {
            return;
        }

        if ($this->isAfterPublicClose($when)) {
            return;
        }

        if ($this->isAfterPublicOpen($when)) {
            return $this->getHoursForHeader($when, true);
        }

        return $this->getHoursForHeader($when);
    }

    public function getHoursTableForHeader($when = null)
    {
        $when = $when
            ? clone $when
            : Carbon::now();

        $weekdays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        $items = [];

        // Start on Sunday so that first `addDay` returns Monday
        $when = $when->startOfWeek()->subDay();

        foreach ($weekdays as $weekday) {
            $when = $when->addDay();
            $hours = $this->getHoursForHeaderTable($when);

            if (!empty($items)) {
                $prevItem = array_pop($items);

                if ($prevItem['hours'] === $hours) {
                    $prevItem['end'] = $weekday;
                    array_push($items, $prevItem);
                    continue;
                }

                array_push($items, $prevItem);
            }

            $item = [
                'start' => $weekday,
                'end' => $weekday,
                'hours' => $hours,
            ];

            array_push($items, $item);
        }

        foreach ($items as &$item) {
            $item['days'] = $item['start'] === $item['end']
                ? $item['start']
                : $item['start'] . '–' . $item['end'];
        }

        return $items;
    }

    public function getHoursTableForVisit($when = null)
    {
        $when = $when
            ? clone $when
            : Carbon::now();

        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $items = [];

        // Start on Sunday so that first `addDay` returns Monday
        $when = $when->startOfWeek()->subDay();

        foreach ($weekdays as $weekday) {
            $when = $when->addDay();

            $memberHours = $this->getMemberHoursForVisitTable($when);
            $publicHours = $this->getPublicHoursForVisitTable($when);

            if (!empty($items)) {
                $prevItem = array_pop($items);

                if (
                    $prevItem['member_hours'] === $memberHours &&
                    $prevItem['public_hours'] === $publicHours
                ) {
                    $prevItem['end'] = $weekday;
                    array_push($items, $prevItem);
                    continue;
                }

                array_push($items, $prevItem);
            }

            $item = [
                'start' => $weekday,
                'end' => $weekday,
                'member_hours' => $memberHours,
                'public_hours' => $publicHours,
            ];

            array_push($items, $item);
        }

        foreach ($items as &$item) {
            $item['days'] = $item['start'] === $item['end']
                ? $item['start']
                : $item['start'] . '–' . $item['end'];
        }

        return $items;
    }

    private function getHoursForHeader($when, $hideMemberHours = false)
    {
        $whenFields = $this->getWhenFields($when);

        if (empty($whenFields['public_open']) || empty($whenFields['public_close'])) {
            return;
        }

        if (
            $hideMemberHours ||
            empty($whenFields['member_open']) ||
            empty($whenFields['member_close'])
        ) {
            return sprintf(
                '%s–%s',
                $this->getHourDisplay($whenFields['public_open'], $when),
                $this->getHourDisplay($whenFields['public_close'], $when),
            );
        }

        return sprintf(
            '%s–%s members | %s–%s public',
            $this->getHourDisplay($whenFields['member_open'], $when),
            $this->getHourDisplay($whenFields['member_close'], $when),
            $this->getHourDisplay($whenFields['public_open'], $when),
            $this->getHourDisplay($whenFields['public_close'], $when)
        );
    }

    private function getHoursForHeaderTable($when)
    {
        if ($this->isMuseumClosedToday($when)) {
            return 'Closed';
        }

        $whenFields = $this->getWhenFields($when);

        if (empty($whenFields['public_open']) || empty($whenFields['public_close'])) {
            return 'Open';
        }

        return sprintf(
            '%s–%s',
            $this->getHourDisplay($whenFields['public_open'], $when),
            $this->getHourDisplay($whenFields['public_close'], $when),
        );
    }

    private function getMemberHoursForVisitTable($when)
    {
        if ($this->isMuseumClosedToday($when)) {
            return 'Closed';
        }

        $whenFields = $this->getWhenFields($when);

        if (empty($whenFields['member_open']) || empty($whenFields['member_close'])) {
            return;
        }

        return $this->getHourDisplayForVisitTable(
            $whenFields['member_open'],
            $whenFields['member_close']
        );
    }

    private function getPublicHoursForVisitTable($when)
    {
        if ($this->isMuseumClosedToday($when)) {
            return 'Closed';
        }

        $whenFields = $this->getWhenFields($when);

        if (!empty($whenFields['public_open']) && empty($whenFields['public_close'])) {
            return 'Opens at ' . $this->getHourDisplayForVisitTable($whenFields['public_open']);
        }

        if (empty($whenFields['public_open']) && !empty($whenFields['public_close'])) {
            return 'Closes at ' . $this->getHourDisplayForVisitTable($whenFields['public_close']);
        }

        if (empty($whenFields['public_open']) && empty($whenFields['public_close'])) {
            return 'Open';
        }

        return $this->getHourDisplayForVisitTable(
            $whenFields['public_open'],
            $whenFields['public_close']
        );
    }

    private function getWhenFields($when)
    {
        $dayOfWeek = Str::lower($when->englishDayOfWeek);

        return [
            'is_closed' => $this->entity->{$dayOfWeek . '_is_closed'},
            'member_open' => $this->entity->{$dayOfWeek . '_member_open'},
            'member_close' => $this->entity->{$dayOfWeek . '_member_close'},
            'public_open' => $this->entity->{$dayOfWeek . '_public_open'},
            'public_close' => $this->entity->{$dayOfWeek . '_public_close'},
        ];
    }

    private function isMuseumClosedToday($when)
    {
        $isClosed = $this->getWhenFields($when)['is_closed'];

        return $isClosed ?? false;
    }

    private function isBeforePublicOpen($when)
    {
        $publicOpen = $this->getWhenFields($when)['public_open'];

        return !empty($publicOpen)
            && $when->lessThanOrEqualTo($this->getDateTime($publicOpen, $when));
    }

    private function isAfterPublicOpen($when)
    {
        $publicOpen = $this->getWhenFields($when)['public_open'];

        return !empty($publicOpen)
            && $when->greaterThanOrEqualTo($this->getDateTime($publicOpen, $when));
    }

    private function isBeforePublicClose($when)
    {
        $publicClose = $this->getWhenFields($when)['public_close'];

        return !empty($publicClose)
            && $when->lessThanOrEqualTo($this->getDateTime($publicClose, $when));
    }

    private function isAfterPublicClose($when)
    {
        $publicClose = $this->getWhenFields($when)['public_close'];

        return !empty($publicClose)
            && $when->greaterThanOrEqualTo($this->getDateTime($publicClose, $when));
    }

    private function isDuringPublicHours($when)
    {
        return $this->isAfterPublicOpen($when)
            && $this->isBeforePublicClose($when);
    }

    private function getNextOpen($when, $prefix)
    {
        $nextWhen = clone $when;
        $tries = 0;

        do {
            $nextWhen = $nextWhen->addDay();
            $isClosed = $this->isMuseumClosedToday($nextWhen);
            $tries++;
        } while ($isClosed && $tries < 7);

        if ($tries > 6 && $isClosed) {
            return $prefix . '.';
        }

        return $prefix . ', next open ' . (
            $tries == 1 ? 'tomorrow' : $nextWhen->englishDayOfWeek
        ) . '.';
    }

    private function getClosingHour($when)
    {
        $publicClose = $this->getWhenFields($when)['public_close'];

        return $this->getHourDisplay($publicClose);
    }

    private function getHourDisplay(string $serializedDateInterval)
    {
        $carbonInterval = $this->getCarbonInterval($serializedDateInterval);

        $hour = intval($carbonInterval->format('%h'));
        $min = intval($carbonInterval->format('%i'));

        $hour = $hour > 12
            ? $hour - 12
            : $hour;

        return $min === 0
            ? $hour
            : sprintf(
                '%d:%d',
                $hour,
                $min
            );
    }

    private function getHourDisplayForVisitTable(
        string $serializedDateIntervalStart,
        string $serializedDateIntervalEnd = null
    ) {
        if (empty($serializedDateIntervalEnd)) {
            return sprintf(
                '%s %s',
                $this->getHourDisplay($serializedDateIntervalStart),
                $this->getPeriodDisplay($serializedDateIntervalStart)
            );
        }

        $hourStart = $this->getHourDisplay($serializedDateIntervalStart);
        $hourEnd = $this->getHourDisplay($serializedDateIntervalEnd);

        $periodStart = $this->getPeriodDisplay($serializedDateIntervalStart);
        $periodEnd = $this->getPeriodDisplay($serializedDateIntervalEnd);

        if ($periodStart === $periodEnd) {
            return sprintf(
                '%s–%s %s',
                $hourStart,
                $hourEnd,
                $periodEnd
            );
        }

        return sprintf(
            '%s %s–%s %s',
            $hourStart,
            $periodStart,
            $hourEnd,
            $periodEnd
        );
    }

    private function getPeriodDisplay(string $serializedDateInterval)
    {
        $carbonInterval = $this->getCarbonInterval($serializedDateInterval);

        return intval($carbonInterval->format('%h')) < 12
            ? 'a.m.'
            : 'p.m.';
    }

    private function getDateTime(string $serializedDateInterval, $when)
    {
        $carbonInterval = $this->getCarbonInterval($serializedDateInterval);

        $whenMidnight = clone $when;
        $whenMidnight->hour = 0;
        $whenMidnight->minute = 0;
        $whenMidnight->second = 0;

        return $carbonInterval->convertDate($whenMidnight);
    }

    private function getCarbonInterval(string $serializedDateInterval)
    {
        $dateInterval = new DateInterval($serializedDateInterval);
        $carbonInterval = CarbonInterval::instance($dateInterval);

        return $carbonInterval;
    }
}

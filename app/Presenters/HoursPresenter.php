<?php

namespace App\Presenters;

use App\Models\Hour;
use DateInterval;
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
            return 'Closed today.' . $this->getNextOpen($when);
        }

        if ($this->isAfterPublicClose($when)) {
            return 'Closed now.' . $this->getNextOpen($when);
        }

        if ($this->isDuringPublicHours($when)) {
            return 'Open today until ' . $this->getClosingHour($when);
        }

        return $isMobile ? 'Today' : 'Open today';
    }

    public function getHoursHeader($when = null)
    {
        $when = $when ?? now();

        if ($this->isMuseumClosedToday($when)) {
            return;
        }

        if ($this->isAfterPublicOpen($when)) {
            return;
        }

        $whenFields = $this->getWhenFields($when);

        if (empty($whenFields['public_open']) || empty($whenFields['public_close'])) {
            return;
        }

        if (empty($whenFields['member_open']) || empty($whenFields['member_close'])) {
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

    private function getNextOpen($when)
    {
        $nextWhen = clone $when;
        $tries = 0;

        do {
            $nextWhen = $nextWhen->addDay();
            $isClosed = $this->isMuseumClosedToday($nextWhen);
            $tries++;
        } while ($isClosed && $tries < 7);

        if ($tries > 6 && $isClosed) {
            return '';
        }

        return ' Next open ' . (
            $tries == 1 ? 'tomorrow' : $nextWhen->englishDayOfWeek
        ) . '.';
    }

    private function getClosingHour($when)
    {
        $publicClose = $this->getWhenFields($when)['public_close'];

        return $this->getHourDisplay($publicClose);
    }

    private function getHourDisplay(DateInterval $dateInterval)
    {
        $hour = intval($dateInterval->format('%h'));
        $min = intval($dateInterval->format('%i'));

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

    private function getDateTime(DateInterval $dateInterval, $when)
    {
        $whenMidnight = clone $when;
        $whenMidnight->hour = 0;
        $whenMidnight->minute = 0;
        $whenMidnight->second = 0;

        return CarbonInterval::instance($dateInterval)->convertDate($whenMidnight);
    }
}

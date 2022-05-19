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

        [
            $fieldIsClosed,
            $fieldMemberOpen,
            $fieldMemberClose,
            $fieldPublicOpen,
            $fieldPublicClose,
        ] = $this->getFieldsFromWhen($when);

        // Museum is closed today
        if ($this->entity->{$fieldIsClosed}) {
            return 'Closed today.' . $this->getNextOpen($when);
        }

        // After public hours
        if ($when->greaterThanOrEqualTo($this->getDateTime($fieldPublicClose, $when))) {
            return 'Closed now.' . $this->getNextOpen($when);
        }

        // Before public hours
        if ($when->lessThan($this->getDateTime($fieldPublicOpen, $when))) {
            return $isMobile ? 'Today' : 'Open today';
        }

        // During public hours
        return 'Open today until ' . $this->getHours($fieldPublicClose, $when);
    }

    public function getHoursHeader($when = null)
    {
        $when = $when ?? now();

        [
            $fieldIsClosed,
            $fieldMemberOpen,
            $fieldMemberClose,
            $fieldPublicOpen,
            $fieldPublicClose,
        ] = $this->getFieldsFromWhen($when);

        // Museum is closed today
        if ($this->entity->{$fieldIsClosed}) {
            return;
        }

        // After public hours open
        if ($when->greaterThanOrEqualTo($this->getDateTime($fieldPublicOpen, $when))) {
            return;
        }

        return sprintf(
            '%d—%d members | %d—%d public',
            $this->getHours($fieldMemberOpen, $when),
            $this->getHours($fieldMemberClose, $when),
            $this->getHours($fieldPublicOpen, $when),
            $this->getHours($fieldPublicClose, $when)
        );
    }

    private function getFieldsFromWhen($when)
    {
        $dayOfWeek = Str::lower($when->englishDayOfWeek);

        return [
            $dayOfWeek . '_is_closed',
            $dayOfWeek . '_member_open',
            $dayOfWeek . '_member_close',
            $dayOfWeek . '_public_open',
            $dayOfWeek . '_public_close',
        ];
    }

    private function getNextOpen($when)
    {
        $nextOpen = clone $when;
        $tries = 0;

        do {
            $nextOpen = $nextOpen->addDay();
            $fieldNextDayClosed = Str::lower($nextOpen->englishDayOfWeek) . '_is_closed';
            $tries++;
        } while ($this->entity->{$fieldNextDayClosed} && $tries < 7);

        if ($tries > 6 && $this->entity->{$fieldNextDayClosed}) {
            return '';
        }

        return ' Next open ' . (
            $tries == 1 ? 'tomorrow' : $nextOpen->englishDayOfWeek
        ) . '.';
    }

    private function getHours($field)
    {
        $hours = $this->entity->{$field}->format('%h');

        if (!$hours) {
            return null;
        }

        if (intval($hours) > 12) {
            return intval($hours) - 12;
        }

        return intval($hours);
    }

    private function getDateTime($field, $when)
    {
        $whenClean = clone $when;
        $whenClean->hour = 0;
        $whenClean->minute = 0;
        $whenClean->second = 0;

        $dateInterval = new DateInterval($this->entity->{$field});

        return CarbonInterval::instance($dateInterval)->convertDate($whenClean);
    }
}

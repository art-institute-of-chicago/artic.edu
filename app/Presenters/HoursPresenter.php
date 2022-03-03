<?php

namespace App\Presenters;

use App\Models\Hour;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Str;

class HoursPresenter extends BasePresenter
{
    public function validFrom()
    {
        if ($this->entity->valid_from) {
            return $this->entity->valid_from->format('%M %j, %Y');
        }
    }

    public function validThrough()
    {
        if ($this->entity->valid_through) {
            return $this->entity->valid_through->format('%M %j, %Y');
        }
    }

    public function type()
    {
        return Hour::$types[$this->entity->type];
    }

    /**
     * We assume that member hours are before public hours. E.g., 10–11 members | 11–5 public
     * If we decide to do member hours at a different part of the day in relation
     * to public hours this function will need to be refactored.
     */
    public function display($isMobile = false, $now = null)
    {
        if ($now) {
            $this->entity->setNow($now);
        }

        $dayOfWeek = Str::lower($now->englishDayOfWeek);

        // Museum is closed today
        $fieldIsClosed = $dayOfWeek . '_is_closed';
        $fieldMemberOpen = $dayOfWeek . '_member_open';
        $fieldMemberClose = $dayOfWeek . '_member_close';
        $fieldPublicOpen = $dayOfWeek . '_public_open';
        $fieldPublicClose = $dayOfWeek . '_public_close';

        if ($this->entity->{$fieldIsClosed}) {
            $nextOpen = $now->addDay();
            $fieldNextDayClosed = Str::lower($nextOpen->englishDayOfWeek) . '_is_closed';
            $tries = 1;
            while ($this->entity->{$fieldNextDayClosed} && $tries <=7 ) {
                $nextOpen = $now->addDay();
                $fieldNextDayClosed = Str::lower($nextOpen->englishDayOfWeek) . '_is_closed';
                $tries++;
            }
            return 'Closed today. Next open ' . ($tries == 1 ? 'tomorrow' : $nextOpen->englishDayOfWeek) . '.';
        }

        // Before open member hours
        if ($now->lessThan($this->dateTime($fieldMemberClose))) {
            return ($isMobile ? 'Today ' : 'Open today ')
            . $this->hours($fieldMemberOpen) . '&ndash;' . $this->hours($fieldMemberClose) . ' members | '
            . $this->hours($fieldPublicOpen) . '&ndash;' . $this->hours($fieldPublicClose) . ' public';
        }

        // After public hours
        if ($now->greaterThanOrEqualTo($this->dateTime($fieldPublicClose))) {
            $nextOpen = $now->addDay();
            $fieldNextDayClosed = Str::lower($nextOpen->englishDayOfWeek) . '_is_closed';
            $tries = 1;
            while ($this->entity->{$fieldNextDayClosed} && $tries <= 7) {
                $nextOpen = $now->addDay();
                $fieldNextDayClosed = Str::lower($nextOpen->englishDayOfWeek) . '_is_closed';
                $tries++;
            }

            return 'Closed now. Next open ' . ($tries == 1 ? 'tomorrow' : $nextOpen->englishDayOfWeek) . '.';
        }

        // Any other time
        return 'Open today until ' . $this->hours($fieldPublicClose);
    }

    private function hours($field = null)
    {
        $hours = $this->entity->{$field}->format('%h');

        if (!$hours)
        {
            return null;
        }

        if (intval($hours) > 12)
        {
            return intval($hours) - 12;
        }

        return intval($hours);
    }

    private function dateTime($field) {
        $thisnow = clone $this->entity->getNow();
        $thisnow->hour = 0;
        $thisnow->minute = 0;
        $thisnow->second = 0;
        return CarbonInterval::instance($this->entity->{$field})->convertDate($thisnow);
    }
}

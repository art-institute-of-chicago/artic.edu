<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelpers
{
    /**
     * WEB-2344: Fix event dates from incrementing by UTC offset on save.
     * @link https://github.com/area17/twill/issues/745
     */
    public static function stripTime($value)
    {
        if (!$value) {
            return;
        }

        if (!is_string($value)) {
            return;
        }

        return (new Carbon($value))
            ->setTime(0, 0, 0)
            ->toDateTimeString();
    }

    public static function printDay($date)
    {
        return \Carbon\Carbon::parse($date)->format('D');
    }

    public static function printDate($date)
    {
        return \Carbon\Carbon::parse($date)->format('d');
    }

    public static function printMonth($date)
    {
        return \Carbon\Carbon::parse($date)->format('M');
    }

    /**
     * Format a year date.
     * Formatting cues taken from the dateRangeValues in frontend/js/app.js
     */
    public static function printYear($date)
    {
        if (!is_int($date)) {
            return null;
        }
        if ($date < 0) {
            return abs($date) . ' BCE';
        }
        if ($date <= 1000) {
            return $date . ' CE';
        }
        if ($date == Carbon::now()->year) {
            return 'Present';
        }

        return $date;
    }

    public static function hoursSelectOptions($shortlist = false, $startAt = 0, $endAt = 24)
    {
        $hours = [];

        for ($i = $startAt; $i < $endAt; $i++) {
            $hour = ($i % 12 ?? 12);
            $ampm = ($i >= 12 ? 'pm' : 'am');
            $mins = $shortlist ? ['00', '30'] : ['00', '15', '30', '45'];
            foreach ($mins as $time) {
                // Save hours on DatetimeInterval format to be added later
                $hours["PT{$i}H{$time}M"] = ($hour == 0 ? '12' : "{$hour}") . ":{$time}{$ampm}";
            }
        }

        return collect($hours);
    }

    public static function convertArtworkDates($date)
    {
        if (!$date) {
            return null;
        }
        $formatdate = '';

        if ($date < 0) {
            $formatdate = abs($date) . ' BCE';
        } elseif ($date < 1000) {
            $formatdate = $date . ' CE';
        } else {
            $formatdate = $date;
        }

        return $formatdate;
    }

    public static function yearIncrements()
    {
        return [
            -8000, -7000, -6000, -5000, -4000, -3000, -2000, -1000,
            1, 500, 1000, 1200, 1400, 1600, 1700, 1800,
            1900, 1910, 1920, 1930, 1940, 1950, 1960, 1970, 1980, 1990,
            2000, 2010, 2020];
    }

    public static function incrementBefore($date)
    {
        $prev = 0;
        foreach (static::yearIncrements() as $year) {
            if ($year > $date) {
                return $prev;
            }
            $prev = $year;
        }

        return $prev;
    }

    public static function incrementAfter($date)
    {
        foreach (static::yearIncrements() as $year) {
            if ($year > $date) {
                return $year;
            }
        }

        return Carbon::now()->year;
    }
}

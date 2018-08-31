<?php

use \Carbon\Carbon;

function printDay($date)
{
    return \Carbon\Carbon::parse($date)->format('D');
}

function printDate($date)
{
    return \Carbon\Carbon::parse($date)->format('d');
}

function printMonth($date)
{
    return \Carbon\Carbon::parse($date)->format('M');
}

/**
 * Format a year date.
 * Formatting cues taken from the dateRangeValues in frontend/js/app.js
 */
function printYear($date)
{
    if (!is_int($date)) {
        return null;
    }
    if ($date < 0) {
        return abs($date) ." BC";
    }
    if ($date <= 1000) {
        return $date ." AD";
    }
    if ($date == Carbon::now()->year) {
        return "Present";
    }
    return $date;
}

function hoursSelectOptions($shortlist = false, $startAt = 0, $endAt = 24)
{
    $hours = [];

    for($i = $startAt; $i < $endAt; $i++) {
        $hour = ($i % 12 ?? 12);
        $ampm = ($i >= 12 ? 'pm' : 'am');
        $mins = $shortlist ? ['00', '30'] : ['00', '15', '30', '45'];
        foreach($mins as $time) {
            // Save hours on DatetimeInterval format to be added later
            $hours["PT{$i}H{$time}M"] = ($hour == 0 ? "12" : "{$hour}") .":{$time}{$ampm}";
        }
    }

    return collect($hours);
}

function convertArtworkDates($date)
{
    $formatdate = "";

    if($date < 0) {
        $formatdate = abs($date) . " BC";
    } else if($date < 1000) {
        $formatdate = $date . " AD";
    } else {
        $formatdate = $date;
    }

    return $formatdate;
}

function yearIncrements()
{
    return [
        -8000, -7000, -6000, -5000, -4000, -3000, -2000, -1000,
        1, 500, 1000, 1200, 1400, 1600, 1700, 1800,
        1900, 1910, 1920, 1930, 1940, 1950, 1960, 1970, 1980, 1990,
        2000, 2010];
}

function incrementBefore($date)
{
    foreach (yearIncrements() as $year)
    {
        if ($year > $date)
        {
            return $prev;
        }
        $prev = $year;
    }
}

function incrementAfter($date)
{
    foreach (yearIncrements() as $year)
    {
        if ($year > $date)
        {
            return $year;
        }
    }
}

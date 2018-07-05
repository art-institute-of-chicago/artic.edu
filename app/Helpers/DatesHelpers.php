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

function hoursSelectOptions($shortlist = false)
{
    $hours = [];

    for($i = 0; $i < 24; $i++) {
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

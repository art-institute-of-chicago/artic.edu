<?php

namespace Database\Seeders;

use App\Models\EmailSeries;
use Illuminate\Database\Seeder;

class EmailSeriesSeeder extends Seeder
{
    public function run()
    {
        $series = EmailSeries::where('title', 'Sustaining Fellow Tickets on Sale/Registration Open/RSVP')->delete();
        $series = EmailSeries::firstOrNew(['title' =>  'Luminary Tickets on Sale/Registration Open/RSVP']);
        $series->save();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\EmailSeries;

class RenameEmailSeriesTitles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $series = EmailSeries::where('title', 'Sustaining Fellow Tickets on Sale/Registration Open/RSVP')->first();
        $series->title = 'Luminary Tickets on Sale/Registration Open/RSVP';
        $series->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $series = EmailSeries::where('title', 'Luminary Tickets on Sale/Registration Open/RSVP')->first();
        $series->title = 'Sustaining Fellow Tickets on Sale/Registration Open/RSVP';
        $series->save();
    }
}

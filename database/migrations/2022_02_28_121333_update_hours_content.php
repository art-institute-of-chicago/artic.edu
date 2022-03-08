<?php

use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class UpdateHoursContent extends Migration
{
    public function up()
    {
        $hours = new \App\Models\Hour();
        $hours->valid_from = Carbon::yesterday();
        $hours->type = 0;
        $hours->title = 'Hours';
        $hours->url = '/visit';
        $hours->monday_is_closed = false;
        $hours->monday_member_open = 'PT10H00M';
        $hours->monday_member_close = 'PT11H00M';
        $hours->monday_public_open = 'PT11H00M';
        $hours->monday_public_close = 'PT17H00M';
        $hours->tuesday_is_closed = true;
        $hours->wednesday_is_closed = true;
        $hours->thursday_is_closed = false;
        $hours->thursday_member_open = 'PT10H00M';
        $hours->thursday_member_close = 'PT11H00M';
        $hours->thursday_public_open = 'PT11H00M';
        $hours->thursday_public_close = 'PT17H00M';
        $hours->friday_is_closed = false;
        $hours->friday_member_open = 'PT10H00M';
        $hours->friday_member_close = 'PT11H00M';
        $hours->friday_public_open = 'PT11H00M';
        $hours->friday_public_close = 'PT17H00M';
        $hours->saturday_is_closed = false;
        $hours->saturday_member_open = 'PT10H00M';
        $hours->saturday_member_close = 'PT11H00M';
        $hours->saturday_public_open = 'PT11H00M';
        $hours->saturday_public_close = 'PT17H00M';
        $hours->sunday_is_closed = false;
        $hours->sunday_member_open = 'PT10H00M';
        $hours->sunday_member_close = 'PT11H00M';
        $hours->sunday_public_open = 'PT11H00M';
        $hours->sunday_public_close = 'PT17H00M';
        $hours->additional_text = 'Members: the first hour of every day, 10–11 a.m., is reserved for member–only viewing.';
        $hours->summary = '<p><strong>Open</strong></p><p>Mondays &amp; Thursday–Sunday:<br>10–11 a.m. members<br>11 a.m.–5 p.m. public</p><p><strong>Closed</strong></p><p>Tuesday–Wednesday</p>';
        $hours->published = true;
        $hours->save();
    }

    public function down()
    {

    }
}

<?php

use Illuminate\Database\Migrations\Migration;

class ChangeHoursHeaderAndDescriptionCopy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->translate('en')->visit_hour_header = '* The first hour of each day is accessible to museum members only';
        $visitPage->translate('en')->visit_hour_subheader = '<p>All dining spaces, libraries, meeting halls, and the Ryan Learning Center are closed until further notice.</p>';
        $visitPage->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->translate('en')->visit_hour_header = 'The museum is temporarily closed.';
        $visitPage->translate('en')->visit_hour_subheader = '<p>Learn more about the museum\'s response to <a href="https://www.artic.edu/visit/covid-19-update" target="_blank">COVID-19</a>.</p>';
        $visitPage->save();
    }
}

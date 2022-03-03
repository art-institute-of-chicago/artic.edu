<?php

use Illuminate\Database\Migrations\Migration;

class ApplyAdditionalVisitUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') != 'testing') {
            $visitPage = \App\Models\Page::where('type', 3)->first();

            $visitPage->translate('en')->visit_hour_intro = 'The Art Institute reopens on July 30, and we\'re so happy to welcome you back to our galleries. Please see below for new hours—including member-only hours—and updated safety policies.';
            $visitPage->translate('en')->visit_hour_header = 'Member-Only Hours';
            $visitPage->translate('en')->visit_hour_subheader = '<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Friday 12-1 p.m.<br/>Saturday&ndash;Sunday 10&ndash;11 a.m.</p>';
            $visitPage->translate('en')->visit_admission_description = '<p>The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents on certain days throughout the year. <a href="/visit/free-admission" target="_blank">Learn more<span class="sr-only"> about free access</span></a>.</p>';
            $visitPage->translate('en')->visit_accessibility_text = 'The Art Institute of Chicago welcomes all visitors and is committed to making its services accessible to everyone. We offer a range of resources for both adults and children with disabilities.';
            $visitPage->translate('en')->visit_accessibility_link_text = 'Learn more about accessibility';
            $visitPage->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') != 'testing') {
            $visitPage = \App\Models\Page::where('type', 3)->first();

            $visitPage->translate('en')->visit_hour_intro = '';
            $visitPage->translate('en')->visit_hour_header = '';
            $visitPage->translate('en')->visit_hour_subheader = '';
            $visitPage->translate('en')->visit_admission_description = '<p>The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents every Wednesday evening from 5:00 to 8:00 p.m. <a href="https://www.artic.edu/visit/aic.prod.a17.io/visit/free-admission" target="_blank">Learn more</a>.</p><p>Visiting&nbsp;with a&nbsp;group? Learn more about&nbsp;<a href="/visit/visit-with-a-group/guided-tours">group&nbsp;admission rates</a>.</p>';
            $visitPage->translate('en')->visit_accessibility_text = '';
            $visitPage->translate('en')->visit_accessibility_link_text = '';
            $visitPage->save();
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitPageDetailsSeeder extends Seeder
{
    public function run(): void
    {
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

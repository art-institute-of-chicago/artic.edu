<?php

namespace Tests\Unit;

use App\Helpers\BlockHelpers;
use App\Models\LandingPage;
use App\Models\Vendor\Block;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

class BlockHelpersTest extends BaseTestCase
{
    use RefreshDatabase;

    public function test_it_gets_headings_with_a_link_label_and_target(): void
    {
        $landingPage = LandingPage::factory()->has(
            Block::factory()->withContentHeading()->count(3)
        )->create();
        $headings = BlockHelpers::getHeadings($landingPage->blocks);
        $this->assertGreaterThan(0, $headings->count());
        foreach ($headings as $heading) {
            $this->assertArrayHasKey('label', $heading);
            $this->assertArrayHasKey('target', $heading);
            $this->assertEquals(
                '#' . str($heading['label'])->slug(),
                $heading['target'],
                'The target is a slugified version of the label prepended with a hash',
            );
        }
    }

    public function test_it_strips_html_tags_from_headings(): void
    {
        $landingPage = LandingPage::factory()->has(
            Block::factory(['content' => ['heading' =>
                '<div><span><p>Lorem ipsum</p></span></div>'
            ]])
        )->create();
        $headings = BlockHelpers::getHeadings($landingPage->blocks);
        $this->assertGreaterThan(0, $headings->count());
        foreach ($headings as $heading) {
            $this->assertEquals(
                strip_tags($heading['label']),
                $heading['label'],
                'The label is does not contain HTML tags',
            );
            $this->assertEquals(
                strip_tags($heading['target']),
                $heading['target'],
                'The target is does not contain HTML tags',
            );
        }
    }
}

<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Illuminate\Support\Facades\View;
use App\Models\DigitalPublication;
use App\Models\Slugs\DigitalPublicationSlug;

class ListingDisplayTest extends BaseTestCase
{
    /**
     * Test the different listing_display switches.
     *
     * @return void
     */
    public function testListingDisplaySwitches()
    {
        // Define the different types of listing_display and the expected components
        $listingDisplays = [
            'feature' => 'components.molecules._m-showcase',
            '3-across' => 'components.molecules._m-listing----digital-publication-article',
            'entries' => 'components.molecules._m-listing----digital-publication-article-entry',
            'group_entries' => 'components.molecules._m-listing----cover',
            'list' => 'components.molecules._m-listing----digital-publication-article',
            'simple_list' => 'components.molecules._m-title-bar'
        ];

        foreach ($listingDisplays as $listingDisplay => $expectedComponent) {
            // Create a mock article with the desired listing_display value
            $mockArticle = \Mockery::mock(DigitalPublication::class);
            $mockArticle->shouldReceive('present')->andReturn((object) [
                'topLevelArticles' => [
                    (object) [
                        'listing_display' => $listingDisplay,
                        'children' => [
                            (object) [
                                'present' => (object) [
                                    'type' => 'Mock Type',
                                    'title' => 'Mock Title',
                                    'title_display' => 'Mock Title Display',
                                    'list_description' => 'Mock List Description',
                                    'url' => 'mock-url'
                                ],
                                'imageFront' => 'mock-image'
                            ]
                        ]
                    ]
                ]
            ]);

            // Render the view with the mock data
            $view = View::make('path.to.your.view', ['item' => $mockArticle])->render();

            // Assert that the expected component is rendered for this listing_display type
            $this->assertStringContainsString($expectedComponent, $view, "Failed asserting that the view contains the component for listing_display: $listingDisplay");
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use DOMDocument;

class CustomTourViewerTest extends BaseTestCase
{
    protected $seed = true;

    /**
     * A test to check whether "Custom Tour - Complete"'s title renders
     * on the viewer page.
     */
    public function test_custom_tour_title_renders(): void
    {
        // Todo: Find by title, not id
        $customTourComplete = CustomTour::find(1);

        $response = $this->get(route('custom-tours.show', 1));

        $tourJson = json_decode($customTourComplete->tour_json, true);

        $response->assertSee($tourJson['title']);
    }

    /**
     * A test to check whether "Custom Tour - Complete"'s description renders
     * on the viewer page and that the appropriate markup is present e.g. id="description".
     */
    public function test_custom_tour_description_renders(): void
    {
        $customTourComplete = CustomTour::find(1);

        $response = $this->get(route('custom-tours.show', 1));

        $tourJson = json_decode($customTourComplete->tour_json, true);

        $response->assertSee($tourJson['description']);

        $content = $response->getContent();

        $this->assertStringContainsString('id="description"', $content, 'The paragraph with ID "description" should be found.');
    }

    /**
     * A test to check whether "Custom Tour - No Description" omits the description markup
     * on the viewer page e.g. id="description" is not present
     */
    public function test_custom_tour_no_description_markup_renders(): void
    {
        $response = $this->get(route('custom-tours.show', 2));

        $content = $response->getContent();

        $this->assertStringNotContainsString('id="description"', $content, 'The paragraph with ID "description" should not be found.');
    }

    /**
     * A test to check whether all of "Custom Tour - Complete"'s artworks' titles
     * render on the viewer page.
     */
    public function test_custom_tour_artworks_title_renders(): void
    {
        $customTourComplete = CustomTour::find(1);

        $response = $this->get(route('custom-tours.show', 1));

        $tourJson = json_decode($customTourComplete->tour_json, true);

        foreach ($tourJson['artworks'] as $index => $artwork) {
            $response->assertSee($tourJson['artworks'][$index]['title']);
        }
    }
}

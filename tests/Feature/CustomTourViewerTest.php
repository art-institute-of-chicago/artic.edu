<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use DOMDocument;

class CustomTourViewerTest extends BaseTestCase
{
    protected $seed = true;

    /**
     * A test to check whether the title renders on the viewer page
     * for "Custom Tour - Complete Content"
     */
    public function test_custom_tour_title_renders(): void
    {
        $customTour = CustomTour::where('tour_json->title', 'Custom Tour - Complete Content')->first();

        $id = $customTour ? $customTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = $customTour->tour_json;

        $response->assertSee($tourJson['title']);
    }

    /**
     * A test to check whether the description renders on the viewer page
     * for "Custom Tour - Complete Content", and that the appropriate
     * markup is present e.g. id="description".
     */
    public function test_custom_tour_description_renders(): void
    {
        $customTour = CustomTour::where('tour_json->title', 'Custom Tour - Complete Content')->first();

        $id = $customTour ? $customTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = $customTour->tour_json;

        $response->assertSee($tourJson['description']);

        $content = $response->getContent();

        $this->assertStringContainsString('class="f-quote"', $content, 'The paragraph with class "f-quote" should be found.');
    }

    /**
     * A test to check whether the description markup is omitted on the viewer page
     * for "Custom Tour - No Description" e.g. id="description" is not present
     */
    public function test_custom_tour_no_extra_markup_renders(): void
    {
        $customTour = CustomTour::where('tour_json->title', 'Custom Tour - No Description')->first();

        $id = $customTour ? $customTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $content = $response->getContent();

        $this->assertStringNotContainsString('class="f-quote"', $content, 'The paragraph with class "f-quote" should not be found.');
    }

    /**
     * A test to check whether all the artworks' titles render on the viewer page for
     * "Custom Tour - Complete Content"
     */
    public function test_custom_tour_artworks_title_renders(): void
    {
        $customTour = CustomTour::where('tour_json->title', 'Custom Tour - Complete Content')->first();

        $id = $customTour ? $customTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = $customTour->tour_json;

        foreach ($tourJson['artworks'] as $index => $artwork) {
            $response->assertSee($tourJson['artworks'][$index]['title']);
        }
    }
}

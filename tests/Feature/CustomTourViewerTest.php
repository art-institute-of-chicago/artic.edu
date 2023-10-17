<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

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
     * on the viewer page.
     */
    public function test_custom_tour_description_renders(): void
    {
        $customTourComplete = CustomTour::find(1);

        $response = $this->get(route('custom-tours.show', 1));

        $tourJson = json_decode($customTourComplete->tour_json, true);

        $response->assertSee($tourJson['description']);
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

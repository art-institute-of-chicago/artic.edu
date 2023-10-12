<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class CustomTourViewerTest extends BaseTestCase
{
    protected $seed = true;

    /**
     * A test to check whether a randomly selected custom tour's title renders
     * on the viewer page.
     */
    public function test_custom_tour_title_renders(): void
    {
        $randomCustomTour = CustomTour::inRandomOrder()->first();

        $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);

        $response->assertSee($tourJson['title']);
    }

    /**
     * A test to check whether a randomly selected custom tour's description renders
     * on the viewer page.
     */
    public function test_custom_tour_description_renders(): void
    {
        $randomCustomTour = CustomTour::inRandomOrder()->first();

        $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);

        $description = $tourJson['description'];

        $response->assertSee($tourJson['description']);
    }

    /**
     * A test to check whether one of a randomly selected custom tour's artwork's title's
     * renders on the viewer page.
     */
    public function test_custom_tour_artworks_title_renders(): void
    {
        $randomCustomTour = CustomTour::inRandomOrder()->first();

        $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);

        $randomArtwork = array_rand($tourJson['artworks']);

        $response->assertSee($tourJson['artworks'][$randomArtwork]['title']);
    }
}

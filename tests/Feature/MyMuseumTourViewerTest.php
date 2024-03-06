<?php

namespace Tests\Feature;

use App\Models\MyMuseumTour;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class MyMuseumTourViewerTest extends BaseTestCase
{
    protected $seed = true;

    /**
     * A test to check whether the title renders on the viewer page
     * for "My Museum Tour - Complete Content"
     */
    public function test_my_museum_tour_title_renders(): void
    {
        $myMuseumTour = MyMuseumTour::where('tour_json->title', 'My Museum Tour - Complete Content')->first();

        $id = $myMuseumTour ? $myMuseumTour->id : null;

        $response = $this->get(route('my-museum-tour.show', $id));

        $tourJson = $myMuseumTour->tour_json;

        $response->assertSee($tourJson['title']);
    }

    /**
     * A test to check whether the description renders on the viewer page
     * for "My Museum Tour - Complete Content", and that the appropriate
     * markup is present e.g. id="description".
     */
    public function test_my_museum_tour_description_renders(): void
    {
        $myMuseumTour = MyMuseumTour::where('tour_json->title', 'My Museum Tour - Complete Content')->first();

        $id = $myMuseumTour ? $myMuseumTour->id : null;

        $response = $this->get(route('my-museum-tour.show', $id));

        $tourJson = $myMuseumTour->tour_json;

        $response->assertSee($tourJson['description']);

        $content = $response->getContent();

        $this->assertStringContainsString('class="f-quote"', $content, 'The paragraph with class "f-quote" should be found.');
    }

    /**
     * A test to check whether the description markup is omitted on the viewer page
     * for "My Museum Tour - No Description" e.g. id="description" is not present
     */
    public function test_my_museum_tour_no_extra_markup_renders(): void
    {
        $myMuseumTour = MyMuseumTour::where('tour_json->title', 'My Museum Tour - No Description')->first();

        $id = $myMuseumTour ? $myMuseumTour->id : null;

        $response = $this->get(route('my-museum-tour.show', $id));

        $content = $response->getContent();

        $this->assertStringNotContainsString('class="f-quote"', $content, 'The paragraph with class "f-quote" should not be found.');
    }

    /**
     * A test to check whether all the artworks' titles render on the viewer page for
     * "My Museum Tour - Complete Content"
     */
    public function test_my_museum_tour_artworks_title_renders(): void
    {
        $myMuseumTour = MyMuseumTour::where('tour_json->title', 'My Museum Tour - Complete Content')->first();

        $id = $myMuseumTour ? $myMuseumTour->id : null;

        $response = $this->get(route('my-museum-tour.show', $id));

        $tourJson = $myMuseumTour->tour_json;

        foreach ($tourJson['artworks'] as $index => $artwork) {
            $response->assertSee($tourJson['artworks'][$index]['title']);
        }
    }
}

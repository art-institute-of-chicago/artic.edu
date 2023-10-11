<?php

namespace Tests\Feature;

use App\Models\CustomTour;
use Database\Seeders\CustomTourSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

class CustomTourViewerTest extends BaseTestCase
{

    protected $seed = true;

    /**
     * A basic feature test example.
     */
    public function test_custom_tour_title_renders(): void
    {
         $randomCustomTour = CustomTour::inRandomOrder()->first();

         $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);

        $response->assertSee($tourJson['title']);
    }

    public function test_custom_tour_description_renders(): void
    {
        $randomCustomTour = CustomTour::inRandomOrder()->first();

        $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);

        $response->assertSee($tourJson['description']);
    }

    public function test_custom_tour_artworks_title_renders(): void
    {
        $randomCustomTour = CustomTour::inRandomOrder()->first();

        $id = $randomCustomTour ? $randomCustomTour->id : null;

        $response = $this->get(route('custom-tours.show', $id));

        $tourJson = json_decode($randomCustomTour->tour_json, true);


        // Todo: Randomise the artwork id i.e. get the total number of artworks and generate a random number between 0 - length-1
        $response->assertSee($tourJson['artworks'][0]['title']);
    }
}

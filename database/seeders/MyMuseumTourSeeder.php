<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\MyMuseumTour;
use Illuminate\Database\Seeder;

class MyMuseumTourSeeder extends Seeder
{
    public function run(): void
    {
        // My Museum Tour - Complete Content
        $tourJson = [
            "title" => "My Museum Tour - Complete Content",
            "description" => "My Museum Tour description",
            "artworks" => [
                [
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "Note about Lion (One of a Pair, South Pedestal)",
                ],
                [
                    "id" => 28560,
                    "title" => "The Bedroom",
                    "objectNote" => "Note about The Bedroom",
                ],
                [
                    "id" => 117266,
                    "title" => "Nightlife",
                    "objectNote" => "Note about Nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "Note about Blue and Green Music",
                ],
                [
                    "id" => 64818,
                    "title" => "Stacks of Wheat (End of Summer)",
                    "objectNote" => "Note about Stacks of Wheat (End of Summer)",
                ],
            ],
        ];

        $myMuseumTour = new MyMuseumTour();
        $myMuseumTour->tour_json = $tourJson;
        $myMuseumTour->save();

        // My Museum Tour - No Description
        $tourJson = [
            "title" => "My Museum Tour - No Description",
            "description" => "",
            "artworks" => [
                [
                    "id" => 117266,
                    "title" => "Nightlife",
                    "objectNote" => "Note about Nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "Note about Blue and Green Music",
                ],
                [
                    "id" => 64818,
                    "title" => "Stacks of Wheat (End of Summer)",
                    "objectNote" => "Note about Stacks of Wheat (End of Summer)",
                ],
            ],
        ];

        $myMuseumTour = new MyMuseumTour();
        $myMuseumTour->tour_json = $tourJson;
        $myMuseumTour->save();

        LandingPage::factory(['title' => 'My Museum Tour'])->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\CustomTour;
use Illuminate\Database\Seeder;

class CustomTourSeeder extends Seeder
{
    public function run(): void
    {
        // Custom Tour - Complete
        $tourJson = [
            "title" => "Custom Tour - Complete",
            "description" => "My custom tour description",
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

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

        // Custom Tour - No Description
        $tourJson = [
            "title" => "Custom Tour - No Description",
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

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();
    }
}

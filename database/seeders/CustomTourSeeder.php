<?php

namespace Database\Seeders;

use App\Models\CustomTour;
use Illuminate\Database\Seeder;

class CustomTourSeeder extends Seeder
{
    public function run(): void
    {
        // First Custom Tour
        $tourJson = [
            "title" => "My custom tour title",
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
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

        // Second Custom Tour
        $tourJson = [
            "title" => "Another custom tour title",
            "description" => "Another custom tour description",
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

        // Third Custom Tour
        $tourJson = [
            "title" => "A third custom tour title",
            "description" => "A third custom tour description",
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
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

        // Fourth Custom Tour
        $tourJson = [
            "title" => "A fourth custom tour title",
            "description" => "A fourth custom tour description",
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
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "Note about Lion (One of a Pair, South Pedestal)",
                ],
                [
                    "id" => 28560,
                    "title" => "The Bedroom",
                    "objectNote" => "Note about The Bedroom",
                ],
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

        // Fifth Custom Tour
        $tourJson = [
            "title" => "A fifth custom tour title",
            "description" => "A fifth custom tour description",
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
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "Note about Lion (One of a Pair, South Pedestal)",
                ],
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();
    }
}

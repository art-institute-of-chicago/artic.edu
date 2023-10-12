<?php

namespace Database\Seeders;

use App\Models\CustomTour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CustomTourSeeder extends Seeder
{
    public function run(): void
    {
        // Custom Tour
        $tourJson = [
            "title" => "My custom tour title",
            "description" => "My custom tour description",
            "artworks" => [
                [
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "note about the lion",
                ],
                [
                    "id" => 28560,
                    "title" => "The Bedroom",
                    "objectNote" => "note about the bedroom",
                ],
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

        // Another Custom Tour
        $tourJson = [
            "title" => "Another custom tour title",
            "description" => "Another custom tour description",
            "artworks" => [
                [
                    "id" => 117266,
                    "title" => "Nightlife",
                    "objectNote" => "note about the nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "note about the music",
                ],
                [
                    "id" => 64818,
                    "title" => "Stacks of Wheat (End of Summer)",
                    "objectNote" => "note about the wheat",
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
                    "objectNote" => "note about the nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "note about the music",
                ],
                [
                    "id" => 64818,
                    "title" => "Stacks of Wheat (End of Summer)",
                    "objectNote" => "note about the wheat",
                ],
                [
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "note about the lion",
                ],
                [
                    "id" => 28560,
                    "title" => "The Bedroom",
                    "objectNote" => "note about the bedroom",
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
                    "objectNote" => "note about the nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "note about the music",
                ],
                [
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "note about the lion",
                ],
                [
                    "id" => 28560,
                    "title" => "The Bedroom",
                    "objectNote" => "note about the bedroom",
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
                    "objectNote" => "note about the nightlife",
                ],
                [
                    "id" => 24306,
                    "title" => "Blue and Green Music",
                    "objectNote" => "note about the music",
                ],
                [
                    "id" => 656,
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "objectNote" => "note about the lion",
                ],
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\CustomTour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CustomTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tourJson = [
            "title" => "My custom tour title",
            "description" => "My custom tour description",
            "artworks" => [
                [
                    "id" => 656,
                    "image_id" => "6b1edb9c-0f3f-0ee3-47c7-ca25c39ee360",
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "description" => "Object description",
                    "artist" => "Artist name",
                    "date" => "1888",
                    "gallery_title" => "Michigan Avenue entrance/steps",
                    "latitude" => null,
                    "longitude" => null,
                    "objectNote" => "note about the lion",
                ],
                [
                    "id" => 656,
                    "image_id" => "6b1edb9c-0f3f-0ee3-47c7-ca25c39ee360",
                    "title" => "Lion (One of a Pair, South Pedestal)",
                    "description" => "Object description",
                    "artist" => "Artist name",
                    "date" => "1888",
                    "gallery_title" => "Michigan Avenue entrance/steps",
                    "latitude" => null,
                    "longitude" => null,
                    "objectNote" => "note about the lion",
                ],
            ],
        ];

        $customTour = new CustomTour();
        $customTour->tour_json = json_encode($tourJson);
        $customTour->save();

//        $customTour = CustomTour::create([
//            'id' => 1,
//            'tour_json' => [
//                "title" => "My custom tour title",
//                "description" => "My custom tour description",
//                "artworks" => [
//                    [
//                        "id" => 656,
//                        "image_id" => "6b1edb9c-0f3f-0ee3-47c7-ca25c39ee360",
//                        "title" => "Lion (One of a Pair, South Pedestal)",
//                        "description" => "Object description",
//                        "artist" => "Artist name",
//                        "date" => "1888",
//                        "gallery_title" => "Michigan Avenue entrance/steps",
//                        "latitude" => null,
//                        "longitude" => null,
//                        "objectNote" => "note about the lion",
//                    ],
//                    [
//                        "id" => 656,
//                        "image_id" => "6b1edb9c-0f3f-0ee3-47c7-ca25c39ee360",
//                        "title" => "Lion (One of a Pair, South Pedestal)",
//                        "description" => "Object description",
//                        "artist" => "Artist name",
//                        "date" => "1888",
//                        "gallery_title" => "Michigan Avenue entrance/steps",
//                        "latitude" => null,
//                        "longitude" => null,
//                        "objectNote" => "note about the lion",
//                    ],
//                ],
//            ],
//        ]);
    }
}

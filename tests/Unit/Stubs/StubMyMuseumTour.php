<?php

namespace Tests\Unit\Stubs;

class StubMyMuseumTour
{
    public $id = 101;

    public $tour_json = [
        'title' => 'My Afternoon at the Museum',
        'description' => 'A personal tour of favorites.',
        'touristType' => 'Art lover',
        'artworks' => [
            [
                'id' => 111,
                'title' => 'Water Lilies',
                'artist_title' => 'Claude Monet',
                'display_date' => '1906',
                'description' => 'A water lily painting.',
                'image_id' => 'monet-waterlilies',
            ],
            [
                'id' => 112,
                'title' => 'The Bedroom',
                'artist_title' => 'Vincent van Gogh',
                'display_date' => '1889',
                'image_id' => null,
            ],
        ],
    ];
}

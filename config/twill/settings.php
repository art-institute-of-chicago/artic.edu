<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twill media crop definitions
    |--------------------------------------------------------------------------
    |
    | Global role/crop definition for models' and blocks' medias.
    |
     */
    'crops' => [
        'image' => [
            'desktop' => [
                [
                    'name' => 'desktop',
                    'ratio' => 0,
                ],
            ],
        ],
        'family_cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'banner' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 200 / 24,
                ],
            ],
        ],
        'membership_banner_image' => [
            'desktop' => [
                [
                    'name' => 'desktop',
                    'ratio' => 0,
                ],
            ],
        ],
        'listing_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'dining_cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'experience_image' => [
            'default' => [
                [
                    'name' => 'free',
                    'ratio' => null,
                ],
                [
                    'name' => '16:9',
                    'ratio' => 16 / 9
                ],
                [
                    'name' => '9:16',
                    'ratio' => 9 / 16
                ],
                [
                    'name' => '4:3',
                    'ratio' => 4 / 3
                ],
                [
                    'name' => '1:1',
                    'ratio' => 1 / 1
                ],
                [
                    'name' => '3:4',
                    'ratio' => 3 / 4
                ]
            ]
        ],
        'artist_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 3 / 4,
                ],
            ],
        ],
        'left_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
        ],
        'right_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
        ],

    ],
];

<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Asset extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/assets',
        'resource'   => '/api/v1/assets/{id}',
        'search'     => '/api/v1/assets/search'
    ];

    public function scopeMultimedias($query)
    {
        $params = [
            'resources' => ['assets', 'sections', 'sites']
        ];

        return $query->rawQuery($params);
    }

    public function scopeMultimediaForArtwork($query, $artworkId)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "bool" => [
                            "should" => [
                                [
                                    "term" => [
                                        "artwork_ids" => $artworkId
                                    ],
                                ],
                                [
                                    "term" => [
                                        "artwork_id" => $artworkId
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "bool" => [
                            "should" => [
                                [
                                    "bool" => [
                                        "must" => [
                                            [
                                                "term" => [
                                                    "artwork_ids" => $artworkId
                                                ]
                                            ],
                                            [
                                                "term" => [
                                                    "is_multimedia_resource" => true
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }
}

<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Libraries\Api\Builders\ApiModelBuilderSearch;
use Illuminate\Support\Carbon;

class Search extends BaseApiModel
{

    protected $endpoints = [
        'search' => '/api/v1/search',
        'autocomplete' => '/api/v1/autocomplete'
    ];

    public $typeMap = [
        'artworks'    => 'App\Models\Api\Artwork',
        'exhibitions' => 'App\Models\Api\Exhibition',
        'agents'      => 'App\Models\Api\Artist',
        'sections'    => 'App\Models\Api\Section'
    ];

    // Use a search Builder to overload the search function to allow
    // different types
    public function newApiModelBuilder($query)
    {
        return new ApiModelBuilderSearch($query);
    }

    public function scopeAggregationType($query)
    {
        $aggs = [
            'types' => [
                'terms' => [
                    'field' => 'api_model'
                ]
            ]
        ];

        return $query->aggregations($aggs);
    }

    public function scopeMultimedia($query, $id)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'bool' => [
                            'should' => [
                                0 => ['term' => ['artwork_ids' => $id]],
                                1 => ['term' => ['artwork_id' => $id]],
                            ],
                        ],
                    ],
                    1 => [
                        'bool' => [
                            'should' => [
                                0 => [
                                    'bool' => [
                                        'must' => [
                                            0 => ['terms' => ['api_model' => ['videos', 'texts', 'links', 'sounds', 'images']]],
                                            1 => ['term' => ['is_multimedia' => true]],
                                        ],
                                    ],
                                ],
                                1 => [
                                    'bool' => [
                                        'must_not' => [
                                            0 => ['terms' => ['api_model' => ['videos', 'texts', 'links', 'sounds', 'images']]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }


    public function scopeClassroomResources($query, $id)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'bool' => [
                            'should' => [
                                0 => ['term' => ['artwork_ids' => $id]],
                                1 => ['term' => ['artwork_id' => $id]],
                            ],
                        ],
                    ],
                    1 => [
                        'bool' => [
                            'should' => [
                                0 => [
                                    'bool' => [
                                        'must' => [
                                            0 => ['terms' => ['api_model' => ['videos', 'texts', 'links', 'sounds', 'images']]],
                                            1 => ['term' => ['is_classroom_resource' => true]],
                                        ],
                                    ],
                                ],
                                1 => [
                                    'bool' => [
                                        'must_not' => [
                                            0 => ['terms' => ['api_model' => ['videos', 'texts', 'links', 'sounds', 'images']]],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // dd($query->rawSearch($params));
        return $query->rawSearch($params);
    }

}

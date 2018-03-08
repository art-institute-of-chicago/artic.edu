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

    // This defines how to map a returned type to one of our API models
    // IF IT'S NOT HERE IT WILL BE REMOVED FROM THE RESULTS
    public $typeMap = [
        'artworks'    => 'App\Models\Api\Artwork',
        'exhibitions' => 'App\Models\Api\Exhibition',
        'agents'      => 'App\Models\Api\Artist',
        'sections'    => 'App\Models\Api\Section'
    ];

    // Use an overloaded ApiModelBuilder (ApiModelBuilderSearch).
    // On that builder, we will to overload the search function to allow
    // searching for multiple types and segregate them when returning a call
    // Or simply return all API models shuffled in the correct order (see code)
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

        return $query->rawSearch($params);
    }

}

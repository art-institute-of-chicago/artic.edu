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
    // On that builder, we will overload the search function to allow
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

    public function scopeAllAggregations($query)
    {
        $aggs = [
            'artists' => [
                'terms' => [
                    'field' => 'artist_ids',
                ]
            ],
            'styles' => [
                'terms' => [
                    'field' => 'style_ids'
                ]
            ],
            'materials' => [
                'terms' => [
                    'field' => 'material_ids'
                ]
            ],
            'classifications' => [
                'terms' => [
                    'field' => 'classification_ids'
                ]
            ],
            'subjects' => [
                'terms' => [
                    'field' => 'subject_ids'
                ]
            ],
            "places" => [
                "terms" => [
                    "field" => "place_of_origin.keyword"
                ]
            ],
            "departments" => [
                "terms" => [
                    "field" => "department_id"
                ]
            ]
        ];

        return $query->aggregations($aggs);
    }

    public function scopeByDepartments($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'department_id');
    }

    public function scopeByPlaces($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'place_of_origin.keyword');
    }

    public function scopeByClassifications($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'classification_ids');
    }

    public function scopeByMaterials($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'material_ids');
    }

    public function scopeByArtists($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'artist_ids');
    }

    public function scopeBySubjects($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'subject_ids');
    }

    public function scopeByStyles($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'style_ids');
    }

    public function scopeByListType($query, $ids, $parameter)
    {
        if (empty($ids)) {
            return $query;
        }

        //Transform the ID into an array. It could be multiple items comma separated
        $ids = is_array($ids) ? $ids : explode(",", $ids);

        foreach($ids as $id) {
            $elements[] = [
                "term" => [
                    $parameter => $id
                ]
            ];
        }

        $params = [
            "bool" => [
                "must" => $elements
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeDateMin($query, $date)
    {
        if (empty($date)) {
            return $query;
        }

        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "date_start" => [
                                "gte" => $this->transformDate($date)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeDateMax($query, $date)
    {
        if (empty($date)) {
            return $query;
        }

        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "date_end" => [
                                "lte" => $this->transformDate($date)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    protected function transformDate($date) {
        // Date could come with BC, AD, or 'Present'

        if (str_contains($date, 'BC')) {
            $date = - (integer) $date;
        } else {
            if (str_contains($date, 'Present')) {
                $date = Carbon::now()->year;
            } else {
                $date = (integer) $date;
            }
        }

        return $date;
    }

    public function scopeByGallery($query, $id)
    {
        $params = [
            "term" => [
                "gallery_id" => $id
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeByIds($query, $ids)
    {
        $ids = is_array($ids) ? $ids : explode(",", $ids); //Transform the ID into an array

        $params = [
            "terms" => [
                "id" => $ids
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeSortBy($query, $field)
    {
        $params = [
            "sort" => [
                "{$field}.keyword"
            ]
        ];

        return $query->rawQuery($params);
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

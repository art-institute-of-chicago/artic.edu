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

    protected function buildListAggregation($name, $parameter, $queryFilter = null)
    {
        $agg = [
            $name => [
                'terms' => [
                    'field' => $parameter,
                ]
            ]
        ];

        // To search within a facet build a string with the form: ".*[{FirstUC}{FirstLC}]{Rest}.*"
        // This is defined by AIC.
        if ($queryFilter && !empty($queryFilter)) {
            $firstLetter = substr($queryFilter, 0, 1);
            $rest = substr($queryFilter, 1);
            $searchString = ".*[" . ucfirst($firstLetter) . lcfirst($firstLetter) . "]" .$rest.".*";

            $agg[$name]['terms']['include'] = $searchString;
        }

        return $agg;
    }

    public function scopeAllAggregations($query, $categoryFilter = null, $queryFilter = null)
    {
        // AggregationName => Parameter
        $aggsParams = [
            'classifications'  => 'classification_titles.keyword',
            'artists'          => 'artist_titles.keyword',
            'styles'           => 'style_titles.keyword',
            'materials'        => 'material_titles.keyword',
            'subjects'         => 'subject_titles.keyword',
            'places'           => 'place_of_origin.keyword',
            'departments'      => 'department_title.keyword',
            'is_public_domain' => 'is_public_domain'
        ];

        $aggs = [];
        foreach ($aggsParams as $facet => $parameter) {
            if ($categoryFilter == $facet) {
                $aggs = array_merge($aggs ,$this->buildListAggregation($facet, $parameter, $queryFilter));
            } else {
                $aggs = array_merge($aggs, $this->buildListAggregation($facet, $parameter));
            }
        }

        return $query->aggregations($aggs);
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

    public function scopeAggregationClassifications($query, $max = 3)
    {
        $aggs = [
            'classifications' => [
                'terms' => [
                    'field' => 'classification_titles.keyword',
                    'size'  => $max
                ]
            ]
        ];

        return $query->aggregations($aggs);
    }

    public function scopeByGalleryIds($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'gallery_id');
    }

    public function scopeByDepartmentIds($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'department_id');
    }

    public function scopeByDepartments($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'department_title.keyword');
    }

    public function scopeByPlaces($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'place_of_origin.keyword');
    }

    public function scopeByClassifications($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'classification_titles.keyword');
    }

    public function scopeByMaterials($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'material_titles.keyword');
    }

    public function scopeByArtists($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'artist_titles.keyword');
    }

    public function scopeBySubjects($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'subject_titles.keyword');
    }

    public function scopeByStyles($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'style_titles.keyword');
    }

    public function scopeByTechniques($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'technique_ids');
    }

    public function scopeByThemes($query, $ids)
    {
        return $this->scopeByListType($query, $ids, 'category_ids');
    }

    public function scopeByArtworkIds($query, $ids)
    {
        if (empty($ids)) {
            return $query;
        }

        $ids = is_array($ids) ? $ids : [$ids]; //Transform the ID into an array

        $params = [
            "terms" => [
                "id" => $ids,
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopePublicDomain($query, $value = true)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            'is_public_domain' => ($value == true) //Value could be 1, "1"
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeOnView($query, $value = true)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            'is_on_view' => ($value == true) //Value could be 1, "1"
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
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
}

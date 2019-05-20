<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Libraries\Api\Builders\ApiModelBuilderSearch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Search extends BaseApiModel
{

    protected $endpoints = [
        'search' => '/api/v1/search',
        'msearch' => '/api/v1/msearch',
    ];

    // This defines how to map a returned type to one of our API models
    // IF IT'S NOT HERE IT WILL BE REMOVED FROM THE RESULTS
    public $typeMap = [
        'artworks'    => 'App\Models\Api\Artwork',
        'exhibitions' => 'App\Models\Api\Exhibition',
        'agents'      => 'App\Models\Api\Artist',
        'sections'    => 'App\Models\Api\Section',
        'events'      => 'App\Models\Event',
        'articles'    => 'App\Models\Article',
        'printed-catalogs'    => 'App\Models\PrintedPublication',
        'digital-catalogs'    => 'App\Models\DigitalPublication',
        'static-pages'        => false,
        'generic-pages'       => 'App\Models\GenericPage',
        'research-guides'     => 'App\Models\ResearchGuide',
        'educator-resources'  => 'App\Models\EducatorResource',
        'press-releases'      => 'App\Models\PressRelease',
    ];

    // Use an overloaded ApiModelBuilder (ApiModelBuilderSearch).
    // On that builder, we will overload the search function to allow
    // searching for multiple types and segregate them when returning a call
    // Or simply return all API models shuffled in the correct order (see code)
    public function newApiModelBuilder($query)
    {
        return new ApiModelBuilderSearch($query);
    }

    protected function buildListAggregation($name, array $parameter, $queryFilter = null)
    {
        $agg = [
            $name => [
                'terms' => [
                    'field' => $parameter['field'],
                    'size' => $parameter['size'],
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

    /**
     * Year used to determine recent accquisitions. Our business logic is as follows:
     *
     * From Jan 1st to June 30th, look at the current year, and the previous year. From July 1st to Dec 31st,
     * look at the current year, and the next year. Our aim is to show approx. 1.5 years of recent accquisitions.
     */
    public function recentAcquisitionConsideredYear()
    {
        $curMonth = date("m");
        $curHalf = ceil($curMonth/6);
        return date("Y") - ($curHalf % 2);
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
            'departments'      => [
                'field' => 'department_title.keyword',
                'size' => 20,
            ],
            'is_public_domain' => 'is_public_domain'
        ];

        // Standardize to array with default size 5
        $aggsParams = array_map(function ($param) {
            return is_array($param) ? $param : [
                'field' => $param,
                'size' => 5,
            ];
        }, $aggsParams);

        // If we get a category filter, then we should just pass that aggregation
        // to improve performance. This is done because it means we are searching over that category.
        $aggs = [];
        foreach ($aggsParams as $facet => $parameter) {
            if ($categoryFilter) {
                if ($categoryFilter == $facet) {
                    $aggs = array_merge($aggs, $this->buildListAggregation($facet, $parameter, $queryFilter));
                }
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

    public function scopeByGalleryIdsOnView($query, $ids)
    {
        $result = $this->scopeByGalleryIds($query, $ids);
        $result = $this->scopeOnView($query, true);

        return $result;
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

    public function scopeRecentAcquisition($query, $value = null)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "fiscal_year" => [
                                "gte" => $this->recentAcquisitionConsideredYear()
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeHasMultimedia($query, $value = false)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            'has_multimedia_resources' => ($value == true) //Value could be 1, "1"
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeHasEducationalResources($query, $value = false)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            'has_educational_resources' => ($value == true) //Value could be 1, "1"
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
        $ids = is_array($ids) ? $ids : explode(';', $ids);

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

    public function scopeByColor($query, $hsl)
    {
        if (empty($hsl)) {
            return $query;
        }

        $hsl = explode('-', $hsl);

        // Match `percentInterval` in colorPickerFilter.js
        $percentInterval = 12.5;

        $params = [
            "bool" => [
                "must" => [
                    [
                        [
                            "range" => [
                                "color.h" => [
                                    "gte" => ($hsl[0] - $percentInterval/2 / 100 * 360),
                                    "lte" => ($hsl[0] + $percentInterval/2 / 100 * 360),
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "color.s" => [
                                    "gte" => ($hsl[1] - $percentInterval/2),
                                    "lte" => ($hsl[1] + $percentInterval/2),
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "color.l" => [
                                    "gte" => ($hsl[2] - $percentInterval/2),
                                    "lte" => ($hsl[2] + $percentInterval/2),
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeByMostSimilar($query, $id)
    {
        if (empty($id)) {
            return $query;
        }

        $query->forceEndpoint('msearch');
        $query->boost(FALSE);

        // Generalize this if we want to use this scope on Selections or
        // other pages
        $item = \App\Models\Api\Artwork::query()
              ->findOrFail((Integer) $id);

        $shoulds = [
            $this->basicQuery('classification_id', $item->classification_id, 4),
            $this->basicQuery('artist_id', $item->artist_id, 3),
            $this->basicQuery('style_id', $item->style_id, 2),
        ];

        $date_start = incrementBefore($item->date_start);
        $date_end = incrementAfter($item->date_start);
        $dateQuery = $this->dateQuery($date_start, $date_end, 1);
        array_push($shoulds, $dateQuery);

        // if ($item->color ?? false) {
        //     $colorQuery = $this->colorQuery($item->color);
        //     $colorQuery['bool']['boost'] = 1;
        //     array_push( $shoulds, $colorQuery );
        // }

        // Filter out empty array queries
        $shoulds = array_filter($shoulds);

        $params = [
            "bool" => [
                "should" => collect($shoulds)->values()->all(),
                "minimum_should_match" => 2,
                "filter" => [
                    'exists' => [
                        'field' => 'image_id',
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeYearMin($query, $year)
    {
        if (empty($year)) {
            return $query;
        }

        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "date_start" => [
                                "gte" => $this->transformYear($year)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeYearMax($query, $year)
    {
        if (empty($year)) {
            return $query;
        }

        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "date_end" => [
                                "lte" => $this->transformYear($year)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeYearRange($query, $min, $max)
    {
        if (empty($min)) {
            return $query;
        }
        if (empty($max)) {
            return Carbon::now()->year;
        }

        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "date_start" => [
                                "gte" => $min
                            ]
                        ]
                    ],
                    [
                        "range" => [
                            "date_end" => [
                                "lte" => $max
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    protected function transformYear($year) {
        // Year could come with BC, AD, or 'Present'

        if (Str::contains($year, 'BC')) {
            $year = - (integer) $year;
        } else {
            if (Str::contains($year, 'Present')) {
                $year = Carbon::now()->year;
            } else {
                $year = (integer) $year;
            }
        }

        return $year;
    }

    public function scopeDateMin($query, $date = null)
    {
        if (empty($date)) {
            $date = Carbon::today();
        }
        else {
            $date = Carbon::parse($date);
        }
        $params = [
            "bool" => [
                "must" => [
                    [
                        "range" => [
                            "end_date" => [
                                "gte" => $date->toIso8601String()
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeByIds($query, $ids)
    {
        $ids = is_array($ids) ? $ids : explode(';', $ids); //Transform the ID into an array

        $params = [
            "terms" => [
                "id" => $ids
            ]
        ];

        return $query->rawSearch($params);
    }

    /*
        SortBy works differently depending on the field.
        That's why we differentiate parameters and create special cases.

        Relevance: Do not add anything, default sorting is by relevance
        Date Display: The correct parameter is date_display (with no .keyword added)
        Default: Parameter name with .keywork added.

    */
    public function scopeSortBy($query, $field)
    {
        switch ($field) {
            case 'relevance':
                return $query;

            case 'date_start':
                $params = [
                    "sort" => [
                        $field
                    ]
                ];
                break;

            default:
                $params = [
                    "sort" => [
                        "{$field}.keyword"
                    ]
                ];
                break;
        }

        return $query->rawQuery($params);
    }

    // TODO: Dead code? Remove..?
    public function scopeExhibitionUpcoming($query)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'range' => [
                            'aic_start_at' => [
                                'gte' => 'now',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    // TODO: Dead code? Remove..?
    public function scopeExhibitionHistory($query)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'range' => [
                            'aic_end_at' => [
                                'lte' => 'now',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $query->exhibitionOrderByDate('asc')->rawSearch($params);
    }

    public function scopeExhibitionGlobal($query)
    {
        $params = [
            'bool' => [
                // Without a must clause, one of these must be true:
                'should' => [
                    // ...has already ended
                    [
                        'range' => [
                            'aic_end_at' => [
                                'lte' => 'now/d',
                            ],
                        ],
                    ],
                    // ...started before 2010
                    [
                        'range' => [
                            'aic_start_at' => [
                                'lte' => '2010',
                            ],
                        ],
                    ],
                    [
                        'bool' => [
                            'must' => [
                                // ...be published
                                [
                                    'term' => [
                                        'is_published' => true,
                                    ],
                                ],
                            ],
                            'should' => [
                                // ...and ideally, be featured
                                [
                                    'term' => [
                                        'is_featured' => [
                                            'value' => true,
                                            'boost' => 2,
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

    public function scopePublished($query)
    {
        $params = [
            'bool' => [
                'filter' => [
                    [
                        'bool' => [
                            'should' => [
                                [
                                    'term' => [
                                        'published' => [
                                            'value' => true,
                                        ],
                                    ],
                                ],
                                [
                                    'term' => [
                                        'is_published' => [
                                            'value' => true,
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'bool' => [
                            'should' => [
                                [
                                    'range' => [
                                        'publish_start_date' => [
                                            'lte' => 'now',
                                        ],
                                    ],
                                ],
                                [
                                    'bool' => [
                                        'must_not' => [
                                            'exists' => [
                                                'field' => 'publish_start_date',
                                            ],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'bool' => [
                            'should' => [
                                [
                                    'range' => [
                                        'publish_end_date' => [
                                            'gte' => 'now',
                                        ],
                                    ],
                                ],
                                [
                                    'bool' => [
                                        'must_not' => [
                                            'exists' => [
                                                'field' => 'publish_end_date',
                                            ],
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

    public function scopeExhibitionOrderByDate($query, $direction = 'asc')
    {
        $params = [
            "sort" => [
                'aic_start_at' => $direction
            ]
        ];

        return $query->rawQuery($params);
    }

    protected function basicQuery($field, $value, $boost = 0)
    {
        if (!$value)
        {
            return [];
        }
        return [
            "bool" => [
                "boost" => $boost,
                "must" => [
                    [
                        "term" => [
                            $field => $value,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function dateQuery($date_start, $date_end, $boost = 0)
    {
        if (!$date_start || !$date_end) {
            return [];
        }
        return [
            "bool" => [
                "boost" => $boost,
                "must" => [
                    [
                        "range" => [
                            "date_start" => [
                                "gte" => $date_start
                            ]
                        ]
                    ],
                    [
                        "range" => [
                            "date_end" => [
                                "lte" => $date_end
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    protected function colorQuery($color, $boost = 0)
    {
        if (!$color) {
            return [];
        }
        return [
            "bool" => [
                "boost" => $boost,
                "must" => [
                    [
                        "range" => [
                            "color.h" => [
                                "gte" => ($color->h - 5),
                                "lte" => ($color->h + 5),
                            ]
                        ]
                    ],
                    [
                        "range" => [
                            "color.s" => [
                                "gte" => ($color->s - 5),
                                "lte" => ($color->s + 5),
                            ]
                        ]
                    ],
                    [
                        "range" => [
                            "color.l" => [
                                "gte" => ($color->l - 5),
                                "lte" => ($color->l + 5),
                            ]
                        ]
                    ]
                ],
            ],
        ];
    }
}

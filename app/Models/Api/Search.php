<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Libraries\Api\Builders\ApiModelBuilderSearch;
use Illuminate\Support\Carbon;

class Search extends BaseApiModel
{

    protected $endpoints = [
        'search' => '/api/v1/search',
        'autocomplete' => '/api/v2/autosuggest' // TODO: Dead code?
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
        'printed-catalogs'    => 'App\Models\PrintedCatalog',
        'digital-catalogs'    => 'App\Models\DigitalCatalog',
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
            'departments'      => 'department_title.keyword',
            'is_public_domain' => 'is_public_domain'
        ];

        // If we get a category filter, then we should just pass that aggregation
        // to improve performance. This is done because it means we are searching over that category.
        $aggs = [];
        foreach ($aggsParams as $facet => $parameter) {
            if ($categoryFilter) {
                if ($categoryFilter == $facet) {
                    $aggs = array_merge($aggs ,$this->buildListAggregation($facet, $parameter, $queryFilter));
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

        $params = [
            "bool" => [
                "must" => [
                    [
                        [
                            "range" => [
                                "color.h" => [
                                    "gte" => ($hsl[0] - 5),
                                    "lte" => ($hsl[0] + 5),
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "color.s" => [
                                    "gte" => ($hsl[1] - 5),
                                    "lte" => ($hsl[1] + 5),
                                ]
                            ]
                        ],
                        [
                            "range" => [
                                "color.l" => [
                                    "gte" => ($hsl[2] - 5),
                                    "lte" => ($hsl[2] + 5),
                                ]
                            ]
                        ]
                    ]
                ]
            ]
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

        if (str_contains($year, 'BC')) {
            $year = - (integer) $year;
        } else {
            if (str_contains($year, 'Present')) {
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
                            'start_at' => [
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
                            'end_at' => [
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
        $sortParams = [
            'sort' => [
                [
                    // ensure current + upcoming exhibits are first
                    'is_featured' => 'desc'
                ],
                [
                    // reverse dates for current + upcoming into BC
                    '_script' => [
                        'type' => 'string',
                        'order' => 'desc',
                        'script' => [
                            'lang' => 'painless',
                            'inline' => implode(' ', [
                                // ...for parsing negative datetimes
                                'def sf = DateTimeFormatter.ISO_OFFSET_DATE_TIME;',
                                // ...for current exhibits
                                'if (doc.aic_end_at.date.getMillis() > params.now',
                                ' && doc.aic_start_at.date.getMillis() < params.now',
                                ' && doc.status.value != "Closed" )',
                                '{ return sf.parse("-" + doc.aic_end_at.date.toString()) }',
                                // ...for upcoming exhibits
                                'else if (doc.aic_start_at.date.getMillis() > params.now )',
                                '{ return sf.parse("-" + doc.aic_start_at.date.toString()) }',
                                // ...for past exhibits
                                'else { return doc.aic_end_at.date }',
                            ]),
                            'params' => [
                                'now' => time(),
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $queryParams = [
            'bool' => [
                // Without a must clause, one of these must be true:
                'should' => [
                    // ...be a past exhibition
                    [
                        'range' => [
                            'aic_end_at' => [
                                'lte' => 'now',
                            ],
                        ],
                    ],
                    // ...be a current exhibition
                    [
                        'range' => [
                            'aic_start_at' => [
                                'lte' => 'now',
                            ],
                        ],
                    ],
                    // ...be a featured exhibition
                    [
                        'term' => [
                            'is_featured' => true,
                        ],
                    ],
                ],
            ],
        ];

        return $query->exhibitionOrderByDate('asc')->rawSearch($queryParams)->rawQuery($sortParams);
    }

    public function scopeExhibitionOrderByDate($query, $direction = 'asc')
    {
        $params = [
            "sort" => [
                'start_at' => $direction
            ]
        ];

        return $query->rawQuery($params);
    }
}

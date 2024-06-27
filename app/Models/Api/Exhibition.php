<?php

namespace App\Models\Api;

use Illuminate\Support\Carbon;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Libraries\Api\Models\BaseApiModel;
use App\Helpers\StringHelpers;
use Database\Factories\Api\HasApiFactory;

class Exhibition extends BaseApiModel
{
    use HasFeaturedRelated {
        getCustomRelatedItems as traitGetCustomRelatedItems;
    }

    use HasApiFactory;

    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource' => '/api/v1/exhibitions/{id}',
        'search' => '/api/v1/exhibitions/search',
    ];

    protected $appends = ['date'];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Exhibition';

    protected $presenter = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    /**
     * Fields used when performing a search so we avoid a double call retrieving the complete entities
     */
    public const SEARCH_FIELDS = ['id', 'title', 'status', 'aic_start_at', 'aic_end_at', 'is_boosted', 'thumbnail', 'short_description', 'gallery_title', 'gallery_id', 'image_id', 'api_model'];

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getTypeAttribute()
    {
        return 'exhibition';
    }

    private function commonStatusChecks()
    {
        // If the start and end dates are overriden, don't consider this exhibition as closed
        if ($this->date_display_override) {
            return false;
        }

        // If the status was overriden, return that
        if (method_exists($this, 'getAugmentedModel') && $augmentedModel = $this->getAugmentedModel()) {
            if ($augmentedModel->getOriginal('status_override')) {
                return $augmentedModel->getOriginal('status_override') == 'Closed';
            }
        }
    }

    public function getIsClosedAttribute()
    {
        $this->commonStatusChecks();

        // Otherwise, look at the dates to determine if the exhibition is closed
        if (empty($this->aic_end_at)) {
            if (empty($this->aic_start_at)) {
                return true;
            }

            return $this->dateStart->year < 2010;
        }

        return Carbon::now()->gt($this->dateEnd->endOfDay());
    }

    public function getIsUpcomingAttribute()
    {
        $this->commonStatusChecks();

        // Otherwise, look at the dates to determine if the exhibition is upcoming
        if (empty($this->aic_end_at)) {
            if (empty($this->aic_start_at)) {
                return false;
            }

            return $this->dateStart->year >= 2010;
        }

        return Carbon::now()->lt($this->dateStart->startOfDay());
    }

    public function getIdSlugAttribute()
    {
        return join('/', array_filter([$this->id, $this->getSlug()]));
    }

    public function getTitleSlugAttribute()
    {
        return StringHelpers::getUtf8Slug($this->title);
    }

    public function getAicDateStartAttribute()
    {
        if (!empty($this->aic_start_at)) {
            return new Carbon($this->aic_start_at);
        }
    }

    public function getDateStartAttribute()
    {
        if (!empty($this->aic_start_at)) {
            if ($this->public_start_date !== null) { // Strange, isset didn't work?
                return $this->public_start_date;
            }

            return (new Carbon($this->aic_start_at))->startOfDay();
        }
    }

    public function getDateEndAttribute()
    {
        if (!empty($this->aic_end_at)) {
            if ($this->public_end_date !== null) { // Strange, isset didn't work?
                return $this->public_end_date;
            }

            return (new Carbon($this->aic_end_at))->endOfDay();
        }
    }

    public function getIsClosingSoonAttribute()
    {
        // If the start and end dates are overriden, don't consider this exhibition as closing soon
        if ($this->date_display_override) {
            return false;
        }

        if (!empty($this->dateEnd)) {
            if (empty($this->dateStart) || Carbon::now()->gt($this->dateStart->endOfDay())) {
                return Carbon::now()->between($this->dateEnd->endOfDay()->subWeeks(2), $this->dateEnd->endOfDay());
            }
        }
    }

    public function getIsNowOpenAttribute($ignoreDateDisplayOverride = false)
    {
        // If the start and end dates are overriden, don't consider this exhibition as now open
        if ($this->date_display_override && !$ignoreDateDisplayOverride) {
            return false;
        }
        // If there's an active closure, don't show "NOW OPEN" text
        if (app('closureservice')->getClosure()) {
            return false;
        }

        if (!empty($this->dateStart) && !empty($this->dateEnd)) {
            return Carbon::now()->between($this->dateStart, $this->dateStart->addWeeks(2));
        }
    }

    /**
     * @see ExhibitionPresenter::exhibitionType()
     */
    public function getIsOngoingAttribute()
    {
        if (method_exists($this, 'getAugmentedModel') && $augmentedModel = $this->getAugmentedModel()) {
            if ($augmentedModel->getOriginal('status_override')) {
                return $augmentedModel->getOriginal('status_override') == 'Ongoing';
            }
        }

        if (empty($this->aic_end_at)) {
            if (isset($this->aic_start_at)) {
                if ($this->dateStart->year > 2010) {
                    return Carbon::now()->gt($this->dateStart);
                }
            }
        }

        return false;
    }

    public function getSeoDescriptionAttribute()
    {
        if (!empty($this->meta_description)) {
            return $this->meta_description;
        }

        if (method_exists($this, 'getAugmentedModel') && $augmentedModel = $this->getAugmentedModel()) {
            if ($augmentedModel->getOriginal('list_description')) {
                return $augmentedModel->getOriginal('list_description');
            }
        }

        if (!empty($this->header_copy)) {
            return $this->header_copy;
        }

        if (
            (
                $augmentedModel && $paragraph = $augmentedModel->blocks()->where('type', '=', 'paragraph')->first()
            ) && (
                !empty($paragraph) && $paragraph = $paragraph->content['paragraph']
            ) && (
                !empty($paragraph) && $paragraph = strip_tags($paragraph)
            )
        ) {
            return $paragraph;
        }

        return null;
    }

    public function getListDescriptionAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->short_description)) {
            return $this->short_description;
        }

        if (!empty($this->description)) {
            return StringHelpers::truncateStr($this->description);
        }

        return null;
    }

    public function getDescriptionAttribute($value)
    {
        $desc = nl2br($value);

        return '<p>' . preg_replace('#(<br>[\r\n\s]+){2}#', "</p>\n\n<p>", $desc) . '</p>';
    }

    /**
     * Used for sorting in the admin interface.
     */
    public function scopeOrderBy($query, $field, $direction = 'asc')
    {
        $params = [
            'sort' => [
                "{$field}" => $direction
            ]
        ];

        return $query->rawQuery($params);
    }

    public function scopeOrderByDate($query, $direction = 'asc')
    {
        $params = [
            'sort' => [
                'aic_start_at' => $direction
            ]
        ];

        return $query->rawQuery($params);
    }

    /**
     * Search for all exhibitions for the next 2 weeks, not closed
     */
    public function scopeCurrent($query)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'range' => [
                            'aic_end_at' => [
                                'gte' => 'now',
                            ],
                        ],
                    ],
                    1 => [
                        'range' => [
                            'aic_start_at' => [
                                'lte' => 'now',
                            ],
                        ],
                    ],
                ],
                'must_not' => [
                    'term' => [
                        'status' => 'Closed',
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeUpcoming($query)
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

    public function scopeHistory($query, $year = null)
    {
        if ($year == null) {
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
        } else {
            $start = $year . '-01-01';
            $end = $year . '-12-31';
            $params = [
                'bool' => [
                    'must' => [
                        [
                            'range' => [
                                'aic_start_at' => [
                                    'lte' => $end,
                                ],
                            ],
                        ],
                        [
                            'range' => [
                                'aic_start_at' => [
                                    'gte' => $start,
                                ],
                            ],
                        ],
                        [
                            'bool' => [
                                'should' => [
                                    [
                                        'range' => [
                                            'aic_end_at' => [
                                                'lte' => 'now',
                                            ],
                                        ],
                                    ],
                                    [
                                        'range' => [
                                            'aic_start_at' => [
                                                'lt' => '2011-01-01',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }

        return $query->orderByDate('asc')->rawSearch($params);
    }

    public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }

    public function artists()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'artist_ids');
    }

    public function mainImage()
    {
        return $this->hasMany(\App\Models\Api\Image::class, 'image_id');
    }

    public function extraImages()
    {
        return $this->hasMany(\App\Models\Api\Image::class, 'alt_image_ids');
    }

    public function historyDocuments()
    {
        return $this->hasMany(\App\Models\Api\Asset::class, 'document_ids');
    }

    public function getCustomRelatedItems()
    {
        // if this exhibition is augmented and its augmented model has custom related items, return those
        if ($this->hasAugmentedModel() && $this->getAugmentedModel() && method_exists($this->getAugmentedModel(), 'getCustomRelatedItems')) {
            return $this->getAugmentedModel()->getCustomRelatedItems();
        }

        return collect([]);
    }
}

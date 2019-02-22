<?php

namespace App\Models\Api;

use A17\Twill\Models\Behaviors\HasPresenter;
use App\Libraries\Api\Models\BaseApiModel;
use App\Models\Api\Asset;
use App\Helpers\DatesHelpers;
use App\Models\Behaviors\HasMediasApi;

class Artwork extends BaseApiModel
{
    const RELATED_MULTIMEDIA = 100;
    const EXTRA_IMAGES_LIMIT = 9;

    use HasMediasApi;

    protected $endpoints = [
        'collection' => '/api/v1/artworks',
        'resource' => '/api/v1/artworks/{id}',
        'search' => '/api/v1/artworks/search',
        'boosted' => '/api/v1/artworks/boosted',
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Artwork';

    protected $presenter = 'App\Presenters\Admin\ArtworkPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArtworkPresenter';

    protected $appends = ['fullTitle'];

    protected static $defaultScopes = [
        'include' => ['artist_pivots', 'place_pivots', 'dates', 'catalogue_pivots']
    ];

    // Fields used when performing a search so we avoid a double call retrieving the complete entities
    const SEARCH_FIELDS = ['id', 'title', 'date_display', 'thumbnail', 'image_id', 'api_model', 'artist_pivots', 'artist_title', 'artist_display'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                'field' => 'image_id',
            ],
            'thumbnail' => [
                'field' => 'image_id',
            ],
        ],
    ];

    public function getDescriptionFilteredAttribute()
    {
        return strip_tags($this->description, '<a><p><br><em><strong>');
    }

    public function getFullTitleAttribute()
    {
        $artist = $this->mainArtist ? $this->mainArtist->first() : null;
        return $this->title . ' (' . ($artist->title ?? '') . ' #' . $this->main_reference_number . ')';
    }

    public function getFullArtistAttribute()
    {
        $artist = $this->mainArtist ? $this->mainArtist->first() : null;
        return ($artist->title ?? '') . ($artist->title && $this->date_display ? ', ' : '') . ($this->date_display ?? '');
    }

    public function getListingSubtitleAttribute()
    {
        if ($this->artist_pivots != null && count($this->artist_pivots) > 0) {
            if ($artist = collect($this->artist_pivots)->first()) {
                return $artist->artist_title;
            }
        }
        return $this->artist_title ?? null;
    }

    public function getListingTitleAttribute()
    {
        return join(', ', array_filter([$this->title, $this->date_display]));
    }

    public function getAllTitlesAttribute()
    {
        $titles = collect($this->title)->push($this->alt_titles)->filter()->flatten();
        return join(', ', $titles->toArray());
    }

    public function getArtistDisplayAttribute($value)
    {
        return str_replace("\n", "<br/>", $value);
    }

    public function getDateDisplayAttribute($value)
    {
        return str_replace("\n", "<br/>", $value);
    }

    public function getCataloguesAttribute()
    {
        if (!empty($this->catalogue_pivots)) {
            return collect($this->catalogue_pivots);
        }

    }

    public function getDateBlockAttribute()
    {
        return join('–', array_unique(array_filter([convertArtworkDates($this->date_start), convertArtworkDates($this->date_end)])));
    }

    public function getMultimediaElementsAttribute()
    {
        return Asset::query()
            ->forceEndpoint('generalSearch')
            ->multimediaForArtwork($this->id)
            ->multimediaAssets()
            ->forPage(null, self::RELATED_MULTIMEDIA)
            ->get(["id", "title", "content", "api_model", "is_multimedia_resource", "is_educational_resource", "web_url"]);
    }

    public function getEducationalResourcesAttribute()
    {
        return Asset::query()
            ->forceEndpoint('generalSearch')
            ->educationalForArtwork($this->id)
            ->educationalAssets()
            ->forPage(null, self::RELATED_MULTIMEDIA)
            ->get(["id", "title", "content", "api_model", "is_multimedia_resource", "is_educational_resource", "web_url"]);
    }

    public function getTypeAttribute()
    {
        return 'artwork';
    }

    public function getHeaderTypeAttribute()
    {
        return 'gallery';
    }

    public function getIsOnViewTitleAttribute()
    {
        return join(', ', array_filter([$this->collection_status, $this->gallery_title]));
    }

    public function getDetailDepartmentTitleAttribute()
    {
        return join(' ', array_filter([$this->department_id, $this->department_title]));
    }

    public function getGalleryImagesAttribute()
    {
        return $this->allImages()->count() ? $this->allImages() : null;
    }

    public function getStyleIdAttribute($value)
    {
        if ($value) {
            return $value;
        }
        if (!empty($this->alt_style_ids)) {
            return $this->alt_style_ids[0];
        }
        return null;
    }

    public function getClassificationIdAttribute($value)
    {
        if ($value) {
            return $value;
        }
        if (!empty($this->alt_classification_ids)) {
            return $this->alt_classification_ids[0];
        }
        return null;
    }

    public function videos()
    {
        return $this->hasMany(\App\Models\Api\Video::class, 'video_ids');
    }

    public function artists()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'alt_artist_ids');
    }

    public function mainArtist()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'artist_id');
    }

    public function extraImages()
    {
        return $this->hasMany(\App\Models\Api\Image::class, 'alt_image_ids', self::EXTRA_IMAGES_LIMIT);
    }

    public function allImages()
    {
        $main = $this->imageFront('hero');

        if (!empty($main)) {
            $main['credit'] = $this->getImageCopyright();
            $main['creditUrl'] = $this->getImageCopyrightUrl();
        }

        return collect($this->extraImages)->map(function ($image) {
            if ($image && is_object($image)) {
                $img = $image->imageFront();

                $img['credit'] = ($image->copyright_notice ?? $this->getImageCopyright());
                $img['creditUrl'] = ($image->copyright_notice ? null : $this->getImageCopyrightUrl());
                return $img;
            }
            return false;
        })
        ->prepend($main)
        ->reject(function ($name) {
            return empty($name);
        });
    }

    public function categories()
    {
        return $this->hasMany(\App\Models\Api\Category::class, 'category_ids');
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join(array_filter([$this->id, getUtf8Slug($this->title)]), '/');
    }

    public function getSlugAttribute()
    {
        return route('artworks.show', $this->id, getUtf8Slug($this->title));
    }

    public function getTitleSlugAttribute()
    {
        return getUtf8Slug($this->title);
    }

    public function getImageCopyright()
    {
        return !empty($this->copyright_notice) ? $this->copyright_notice : (
            $this->is_public_domain ? 'CC0 Public Domain Designation' : ''
        );
    }

    public function getImageCopyrightUrl()
    {
        return $this->is_public_domain ? '/image-licensing' : null;
    }


    public function scopeAggregationClassification($query)
    {
        $aggs = [
            'types' => [
                'terms' => [
                    'field' => 'classification_id',
                ],
            ],
        ];

        return $query->aggregations($aggs);
    }

    public function scopeByClassifications($query, $ids)
    {
        if (empty($ids)) {
            return $query;
        }

        $ids = is_array($ids) ? $ids : [$ids]; //Transform the ID into an array

        $params = [
            "bool" => [
                "must" => [
                    [
                        "terms" => [
                            "classification_id" => $ids,
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeByArtists($query, $ids)
    {
        if (empty($ids)) {
            return $query;
        }

        $ids = is_array($ids) ? $ids : [$ids]; //Transform the ID into an array

        $params = [
            "bool" => [
                "must" => [
                    [
                        "terms" => [
                            "artist_id" => $ids,
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeByStyles($query, $ids)
    {
        if (empty($ids)) {
            return $query;
        }

        $ids = is_array($ids) ? $ids : [$ids]; //Transform the ID into an array

        $params = [
            "bool" => [
                "must" => [
                    [
                        "terms" => [
                            "style_id" => $ids,
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

}

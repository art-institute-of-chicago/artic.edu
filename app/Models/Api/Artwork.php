<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Presenters\StaticObjectPresenter;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;
use LakeviewImageService;
use App\Models\Behaviors\HasMediasApi;

class Artwork extends BaseApiModel
{
    use HasMediasApi, HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/artworks',
        'resource'   => '/api/v1/artworks/{id}',
        'search'     => '/api/v1/artworks/search',
        'boosted'    => '/api/v1/artworks/boosted'
    ];

    protected $presenter       = 'App\Presenters\Admin\ArtworkPresenter';
    protected $presenterAdmin  = 'App\Presenters\Admin\ArtworkPresenter';

    protected $appends = ['fullTitle'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                'field'  => 'image_id',
            ],
            'thumbnail' => [
                'field'  => 'image_id',
            ],
        ],
    ];

    public function getClassificationIdsAttribute()
    {
        $ids = $this->alt_classificaiton_ids ?? [];
        array_push($ids, $this->classification_id);
        $ids = array_filter($ids);

        return empty($ids) ? null : $ids;
    }

    public function scopeAggregationClassification($query)
    {
        $aggs = [
            'types' => [
                'terms' => [
                    'field' => 'classification_id'
                ]
            ]
        ];

        return $query->aggregations($aggs);
    }

    public function scopeByClassifications($query, $ids)
    {
        $params = [
            "terms" => [
                "classification_id" => $ids
            ]
        ];

        return $query->rawSearch($params);
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

    public function getFullTitleAttribute()
    {
        $artist = $this->mainArtist ? $this->mainArtist->first() : null;
        return $this->title . ' (' . ($artist->title ?? '') . ' #' . $this->main_reference_number . ')';

    }

    public function extraImages()
    {
        return $this->hasMany(\App\Models\Api\Image::class, 'alt_image_ids');
    }

    public function allImages()
    {
        return collect($this->extraImages)->map(function($image) {
            $img = $image->imageFront();
            $img['credit'] = $this->getImageCopyright();
            return $img;
        })
        ->prepend($this->imageFront('hero'))
        ->reject(function ($name) {
            return empty($name);
        });
    }

    public function getGalleryImagesAttribute()
    {
        return $this->allImages();
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
        return join(array_filter([$this->id, getUtf8Slug($this->title)]), '-');
    }

    public function getSlugAttribute()
    {
        return route('artworks.show', $this->id);
    }

    public function getImageCopyright()
    {
        if (!empty($this->copyright_notice)) {
            return $this->copyright_notice;
        }

        return '';
    }

    public function getTypeAttribute()
    {
        return 'artwork';
    }

    public function getArtworkDetailsBlock()
    {

        $details = [];

        if ($this->artists != null && $this->artists->count() > 0) {
            $details[] = array('key' => str_plural('Artist', $this->artists->count()), 'value' => $this->artists->implode('title', ', '));
        } else {
            if (!empty($this->place_of_origin)) {
                $details[] = array('key' => 'Origin', 'value' => $this->place_of_origin);
            }
        }

        if (!empty($this->alt_titles)) {
            $details[] = array('key' => 'Alternate Names', 'value' => join($this->alt_titles, ', '));
        }
        if (!empty($this->date_display)) {
            $details[] = array('key' => 'Date', 'value' => $this->date_display);
        }
        if (!empty($this->medium)) {
            $details[] = array('key' => 'Medium', 'value' => $this->medium);
        }
        if (!empty($this->dimensions)) {
            $details[] = array('key' => 'Dimensions', 'value' => $this->dimensions);
        }
        if (!empty($this->credit_line)) {
            $details[] = array('key' => 'Credit line', 'value' => $this->credit_line);
        }
        if (!empty($this->main_reference_number)) {
            $details[] = array('key' => 'Reference Number', 'value' => $this->main_reference_number);
        }
        if (!empty($this->copyright_notice)) {
            $details[] = array('key' => 'Copyright', 'value' => $this->copyright_notice);
        }

        $block = array(
          "type"  => 'deflist',
          "items" => $details
        );

        return $block;
    }

    public function getArtworkDescriptionBlocks($multimedia, $resources)
    {
        $blocks = [];

        $content = [];
        if (!empty($this->publication_history)) {
            $block = array(
                'title' => 'Publication History',
                'blocks' => []
            );
            foreach(explode("\n", $this->publication_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->exhibition_history)) {
            $block = array(
                'title' => 'Exhibition History',
                'blocks' => []
            );
            foreach(explode("\n", $this->exhibition_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->provenance_text)) {
            $block = array(
                'title' => 'Provenance',
                'blocks' => []
            );
            foreach(explode("\n", $this->provenance_text) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($multimedia) && $multimedia->count()) {

            $items = [];
            foreach($multimedia as $media) {
                $media->title = $media->publication_title;
                $media->slug = $media->web_url;
                $items[] = $media;
            }

            $block = array(
                'title' => 'Multimedia',
                'blocks' => [
                    [
                        "type" => 'listing',
                        "subtype" => 'media',
                        "items" => $items,
                    ]
                ]
            );

            $content[] = $block;
        }

        if (!empty($resources) && $resources->count()) {

            $items = [];
            foreach($resources as $resource) {
                $items[] = array('label' => $resource->publication_title, 'href' => $resource->web_url);
            }

            $block = array(
                'title' => 'Classroom Resources',
                'blocks' => [
                    [
                        "type" => 'link-list',
                        "links" => $items,
                    ]
                ]
            );

            $content[] = $block;
        }


        $blocks = array(
            "type" => 'accordion',
            "content" => $content
        );


        // dd($content);
        return $blocks;
    }
}

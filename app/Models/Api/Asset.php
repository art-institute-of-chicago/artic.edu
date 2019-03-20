<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Models\Behaviors\HasMediasApi;

class Asset extends BaseApiModel
{
    // We are modifying imageFront to use it when we have a youtube video
    // So let's change the name
    use HasMediasApi {
        imageFront as public imageLake;
    }

    protected $endpoints = [
        'collection' => '/api/v1/assets',
        'resource'   => '/api/v1/assets/{id}',
        'search'     => '/api/v1/assets/search',
        'generalSearch' => '/api/v1/search'
    ];

    // Elements created to ease integration with blade views when converting to an array
    protected $appends = ['iconAfter', 'label', 'href', 'embed', 'media', 'downloadable', 'extension'];

    public $mediasParams = [
        'main' => [
            'default' => [
                'field' => 'lake_guid',
            ],
        ],
    ];

    public function getMediaAttribute()
    {
        return $this->imageLake('main', 'default');
    }

    public function getExtensionAttribute()
    {
        $info = pathinfo($this->title);
        if (isset($info['extension'])) {
            return $info['extension'];
        }
    }

    public function getDownloadableAttribute()
    {
        return true;
    }

    public function imageFront($role = 'hero', $crop = 'default')
    {
        $image = \EmbedConverter::getYoutubeThumbnailImage($this->content);

        if (!empty($image)) {
            return aic_convertFromImageProxy($image, ['source' => 'misc']);
        }
    }

    public function getVideoContentAttribute()
    {
        return \EmbedConverter::convertUrl($this->content);
    }

    public function getContentAttribute($content)
    {
        if (!config('lakeview.cdn_enabled')) {
            return $content;
        }

        // TODO: Consider removing `/iiif` suffix from `config/lakeview.php` values?
        $assets_url = str_replace('/iiif', '/assets', config('lakeview.base_url'));
        $assets_cdn_url = str_replace('/iiif', '/assets', config('lakeview.base_url_cdn'));

        if (starts_with($content, $assets_url)) {
            return str_replace($assets_url, $assets_cdn_url, $content);
        }

        return $content;
    }

    public function getHrefAttribute()
    {
        switch ($this->api_model)
        {
            case 'videos':
                // TODO: look into `triggerMediaModal` behavior
                return '//' . config('app.url') . '/videos/' . $this->id;
            case 'sections':
            case 'sites':
                return $this->web_url;
                break;
        }

        return $this->content;
    }

    public function getLabelAttribute()
    {
        return $this->title;
    }

    public function getEmbedAttribute()
    {
        switch ($this->api_model)
        {
            case 'videos':
                return $this->videoContent;
                break;
            case 'sounds':
                return view('components.molecules._m-listing----sound', [
                    'item' => (object) [
                        'title' => $this->title,
                        'href' => $this->href,
                    ]
                ])->render();
                break;

            // All other cases were deprecated.
            // If needed to add another embed type start here.
        }
    }

    public function getIconAfterAttribute()
    {
        switch ($this->api_model) {
            case 'sounds':
                return 'audio';
            break;
            case 'videos':
                return 'video';
            break;
            default:
                return 'new-window';
            break;

        }
    }

    public function scopeMultimediaAssets($query)
    {
        $params = [
            'resources' => ['images', 'sounds', 'texts', 'videos', 'sections', 'sites']
        ];

        return $query->rawQuery($params);
    }

    public function scopeEducationalAssets($query)
    {
        $params = [
            'resources' => ['images', 'sounds', 'texts', 'videos']
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
                                                    "is_multimedia_resource" => true
                                                ]
                                            ],
                                            [
                                                "exists" => [
                                                    "field" => "content"
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    "bool" => [
                                        "must_not" => [
                                            "terms" => [
                                                "api_model" => ['videos', 'images', 'sounds', 'texts']
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        "bool" => [
                            "should" => [
                                [
                                    "prefix" => [
                                        "content.keyword" => 'https://www.youtube.com'
                                    ]
                                ],
                                [
                                    "bool" => [
                                        "must_not" => [
                                            "term" => [
                                                "api_model" => "videos"
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }

    public function scopeEducationalForArtwork($query, $artworkId)
    {
        $params = [
            "bool" => [
                "must" => [
                    [
                        "term" => [
                            "artwork_ids" => $artworkId
                        ],
                    ],
                    [
                        "term" => [
                            "is_educational_resource" => true
                        ]
                    ],
                    [
                        "exists" => [
                            "field" => "content"
                        ]
                    ],
                    [
                        "bool" => [
                            "should" => [
                                [
                                    "prefix" => [
                                        "content.keyword" => 'https://www.youtube.com'
                                    ]
                                ],
                                [
                                    "bool" => [
                                        "must_not" => [
                                            "term" => [
                                                "api_model" => "videos"
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ];

        return $query->rawSearch($params);
    }
}

<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Asset extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/assets',
        'resource'   => '/api/v1/assets/{id}',
        'search'     => '/api/v1/assets/search',
        'generalSearch' => '/api/v1/search'
    ];

    // Elements created to ease integration with blade views when converting to an array
    protected $appends = ['iconAfter', 'label', 'href', 'subtype', 'embed'];

    public function getSoundContentAttribute()
    {
        // Hardcoded soundcloud embed until AIC returns a proper soundcloud embeds

        return '<iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/348258574&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>';
    }

    public function getVideoContentAttribute()
    {
        return \EmbedConverter::convertUrl($this->content);
    }

    public function getHrefAttribute()
    {
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
                return $this->soundContent;
                break;
            case 'texts':
                return $this->textLinkContent;
                break;
        }
    }

    public function getSubtypeAttribute()
    {
        switch ($this->api_model)
        {
            case 'videos':
            case 'sounds':
                return 'embed';
                break;
            case 'texts':
                return 'link';
                break;
        }
    }

    public function getIconAfterAttribute()
    {
        // If it's not a PDF, print the new window icon

        if (substr($this->content, -4) != '.pdf') {
            return 'new-window';
        }
    }

    public function getTextLinkContentAttribute()
    {
        return $this->content;
    }

    public function scopeMultimediaAssets($query)
    {
        $params = [
            'resources' => ['assets', 'sections', 'sites']
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
                                                    "artwork_ids" => $artworkId
                                                ]
                                            ],
                                            [
                                                "term" => [
                                                    "is_multimedia_resource" => true
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
                                        "content.keyword" => 'http://www.youtube.com'
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
                        "bool" => [
                            "should" => [
                                [
                                    "prefix" => [
                                        "content.keyword" => 'http://www.youtube.com'
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

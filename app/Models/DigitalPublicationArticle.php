<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasNesting;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use App\Enums\DigitalPublicationArticleType;
use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasBlocks;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalPublicationArticle extends AbstractModel implements Sortable
{
    use HasNesting;
    use HasSlug;
    use HasRevisions;
    use HasPosition;
    use HasMedias;
    use HasMediasEloquent;
    use HasBlocks;
    use HasAuthors;
    use Transformable;
    use HasFactory;

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationArticlePresenter';

    protected $fillable = [
        'published',
        'title',
        'title_display',
        'hide_title',
        'list_description',
        'date',
        'article_type',
        'listing_display',
        'suppress_listing',
        'heading',
        'author_display',
        'publish_start_date',
        'digital_publication_id',
        'position',
        'pdf_download_path',
        'cite_as',
        'references',
        'label',
        'grouping_description',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $casts = [
        'date' => 'date',
        'publish_start_date' => 'date',
        'published' => 'boolean',
        'article_type' => DigitalPublicationArticleType::class,
    ];

    public $attributes = [
        'published' => false,
        'article_type' => 'text',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 10 / 3,
                ],
            ],
        ],
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
        'grouping_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'grouping_mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function scopePublished($query)
    {
        parent::scopePublished($query);

        // ...and the parent publication has to be published as well
        return $query->whereHas('digitalPublication', function ($subquery) {
            $subquery->published();
        });
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function getPublishedAttribute()
    {
        return ($this->digitalPublication->isPublished ?? false) && $this->isPublished;
    }

    public function digitalPublication()
    {
        return $this->belongsTo('App\Models\DigitalPublication');
    }

    public function getRouteKeyName()
    {
        return 'digital_publication_slug';
    }

    public function getDigitalPublicationSlugAttribute()
    {
        return join('/', [$this->id, $this->getSlug()]);
    }

    public function getUrlAttribute()
    {
        return $this->present()->getCanonicalUrl();
    }

    public function getUrlWithoutSlugAttribute()
    {
        return route('collection.publications.digital-publications-articles.show', [
            'pubId' => $this->digital_publication_id,
            'pubSlug' => $this->digitalPublication->slug,
            'id' => $this->id,
        ]);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                }
            ],
            [
                'name' => 'web_url',
                'doc' => 'Web URL',
                'type' => 'string',
                'value' => function () {
                    return url($this->url);
                }
            ],
            [
                'name' => 'slug',
                'doc' => 'Slug',
                'type' => 'string',
                'value' => function () {
                    return $this->getSlug();
                }
            ],
            [
                'name' => 'listing_description',
                'doc' => 'Listing Description',
                'type' => 'string',
                'value' => function () {
                    return $this->listing_description;
                }
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                }
            ],
            [
                'name' => 'publish_start_date',
                'doc' => 'Publish Start Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_start_date;
                }
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'text',
                'value' => function () {
                    return $this->present()->blocks;
                }
            ],
            [
                'name' => 'article_type',
                'doc' => 'Type of Article',
                'type' => 'string',
                'value' => function () {
                    return $this->present()->articleType;
                },
            ],
            [
                'name' => 'heading',
                'doc' => 'heading',
                'type' => 'string',
                'value' => function () {
                    return $this->heading;
                },
            ],
            [
                'name' => 'date',
                'doc' => 'Date',
                'type' => 'date',
                'value' => function () {
                    return $this->date;
                },
            ],
            [
                'name' => 'author_display',
                'doc' => 'Author display',
                'type' => 'string',
                'value' => function () {
                    return $this->showAuthors();
                },
            ],
            [
                'name' => 'digital_publication_id',
                'doc' => 'Digital Publication ID',
                'type' => 'integer',
                'value' => function () {
                    return $this->digital_publication_id;
                },
            ],
        ];
    }
}

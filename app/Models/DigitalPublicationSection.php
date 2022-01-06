<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasBlocks;

class DigitalPublicationSection extends AbstractModel implements Sortable
{
    use HasSlug, HasRevisions, HasPosition, HasMedias, HasMediasEloquent, HasBlocks, HasAuthors, Transformable;

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationSectionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationSectionPresenter';

    protected $fillable = [
        'published',
        'title',
        'title_display',
        'list_description',
        'date',
        'type',
        'heading',
        'author_display',
        'publish_start_date',
        'digital_publication_id',
        'position',
        'pdf_download_path',
        'cite_as',
        'references',
        'type_display',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $dates = [
        'date',
        'publish_start_date',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
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
    ];

    const ABOUT = 'about';
    const TEXT = 'text';
    const WORK = 'work';

    public static $types = [
        self::ABOUT => 'About',
        self::TEXT => 'Essays',
        self::WORK => 'Works',
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
                'name' => 'type',
                'doc' => 'Type of Section',
                'type' => 'string',
                'value' => function () {
                    return $this->type;
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

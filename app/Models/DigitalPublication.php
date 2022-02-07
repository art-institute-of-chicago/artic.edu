<?php

namespace App\Models;

use PDO;
use Illuminate\Support\Facades\DB;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class DigitalPublication extends AbstractModel
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent, Transformable, HasRelated;

    protected $fillable = [
        'listing_description',
        'short_description',
        'title',
        'title_display',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'meta_title',
        'meta_description',
        'is_dsc_stub',
        'sponsor_display',
        'welcome_note_display',
        'cite_as',
        'header_title_display',
        'header_subtitle_display',
        'sidebar_title_display',
        'bgcolor',
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationPresenter';

    public $checkboxes = [
        'published',
        'active',
        'public',
        'is_dsc_stub',
    ];

    public $dates = [
        'publish_start_date',
        'publish_end_date',
    ];

    public $searchSections = [];

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'mobile_listing' => [
            [
                'name' => 'default',
                'ratio' => 1,
            ],
        ],
        'banner' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 200 / 24,
                ],
            ],
        ],
    ];

    /**
     * Generates the id-slug type of URL
     * */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join('-', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('collection.publications.digital-publications'), '/', $this->id, '-']);
    }

    public function getUrlAttribute()
    {
        return $this->present()->getCanonicalUrl();
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.collection.articles_publications.digitalPublications.edit', $this->id);
    }

    /**
     * For pinboard and listings
     */
    public function getSubtypeAttribute()
    {
        return 'Digital Publication';
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    /**
     * Alphabetical sort by title [WEB-964]
     * @link https://stackoverflow.com/questions/3252577
     * @link https://stackoverflow.com/questions/47903727
     */
    public function scopeOrdered($query)
    {
        $driver = DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

        return $query->orderByRaw($driver === 'pgsql' ? (
            "regexp_replace(lower(title), '^(an?|the) (.*)$', '\\2, \\1')"
        ) : (
            "CASE
                WHEN title REGEXP '^(\"a|an|the|el|la\")[[:space:]]' = 1 THEN
                    TRIM(SUBSTR(title, INSTR(title, ' ')))
                ELSE title
            END ASC"
        ));
    }

    public function searchSections()
    {
        return $this->searchSections;
    }

    public function addSearchSection($section)
    {
        return $this->searchSections[] = $section;
    }

    public function sections()
    {
        return $this->hasMany('App\Models\DigitalPublicationSection', 'digital_publication_id');
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
                'name' => 'short_description',
                'doc' => 'Short Description',
                'type' => 'string',
                'value' => function () {
                    return $this->short_description;
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
                'name' => 'publish_end_date',
                'doc' => 'Publish End Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_end_date;
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
                'name' => 'related',
                'doc' => 'Related Content',
                'type' => 'array',
                'value' => function () {
                    return $this->transformRelated();
                },
            ],
        ];
    }
}

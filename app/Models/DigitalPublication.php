<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasUnlisted;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use PDO;

class DigitalPublication extends AbstractModel
{
    use HasBlocks;
    use HasFactory;
    use HasFiles;
    use HasMedias;
    use HasMediasEloquent;
    use HasRelated;
    use HasRevisions;
    use HasSlug;
    use HasUnlisted;
    use Transformable;

    protected $fillable = [
        'listing_description',
        'publication_date',
        'hero_caption',
        'title',
        'title_display',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'meta_title',
        'meta_description',
        'is_dsc_stub',
        'is_unlisted',
        'sponsor_display',
        'welcome_note_display',
        'cite_as',
        'header_subtitle_display',
        'bgcolor',
        'toggle_autorelated',
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $presenter = 'App\Presenters\Admin\DigitalPublicationPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DigitalPublicationPresenter';

    public $casts = [
        'publish_start_date' => 'date',
        'publish_end_date' => 'date',
        'published' => 'boolean',
        'public' => 'boolean',
        'is_dsc_stub' => 'boolean',
        'is_unlisted' => 'boolean',
        'toggle_autorelated' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'public' => false,
        'is_dsc_stub' => false,
        'is_unlisted' => false,
        'toggle_autorelated' => false,
    ];

    public $searchArticles = [];

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'banner' => [
                [
                    'name' => 'default',
                    'ratio' => 4 / 3,
                ],
            ],
        ],
        'publications_listing' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
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
        return route('twill.collection.articlesPublications.digitalPublications.edit', $this->id);
    }

    /**
     * For pinboard and listings
     */

    public function getTypeAttribute()
    {
        return 'digital_publication';
    }
    public function getSubtypeAttribute()
    {
        return 'Digital Publication';
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\CatalogCategory', 'catalog_category_digital_publication', 'digital_publication_id');
    }

    public function scopeByCategory($query, $category = null): Builder
    {
        if (!empty($category)) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('catalog_category_id', $category);
            });
        }

        return $this->scopeOrdered($query);
    }

    public function scopeByCategories($query, $categories = null): Builder
    {
        if (empty($categories)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', is_array($categories) ? $categories : [$categories]);
        });
    }

    public function scopeIds($query, $ids = []): Builder
    {
        return $query->whereIn('id', $ids);
    }

    /**
     * Alphabetical sort by title [WEB-964]
     * @link https://stackoverflow.com/questions/3252577
     * @link https://stackoverflow.com/questions/47903727
     */
    public function scopeOrdered($query): Builder
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

    public function searchArticles()
    {
        return $this->searchArticles;
    }

    public function addSearchArticle($article)
    {
        return $this->searchArticles[] = $article;
    }

    public function articles()
    {
        return $this->hasMany('App\Models\DigitalPublicationArticle', 'digital_publication_id');
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

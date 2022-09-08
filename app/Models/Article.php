<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasUnlisted;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends AbstractModel implements Feedable
{
    use HasSlug, HasRevisions, HasMedias, HasMediasEloquent, HasBlocks, Transformable, HasRelated, HasApiRelations, HasFeaturedRelated, HasUnlisted, HasAuthors;

    protected $presenter = 'App\Presenters\Admin\ArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArticlePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateArticle::class,
        'deleted' => \App\Events\UpdateArticle::class,
    ];

    protected $fillable = [
        'published',
        'date',
        'content',
        'title',
        'title_display',
        'heading',
        'list_description',
        'author_display',
        'copy',
        'subtype',
        'citation',
        'layout_type',
        'migrated_node_id',
        'migrated_at',
        'citations',
        'meta_title',
        'meta_description',
        'publish_start_date',
        'publish_end_date',
        'is_unlisted',
        'is_in_magazine',
    ];

    public $slugAttributes = [
        'title',
    ];

    const BASIC = 0;
    const LARGE = 1;

    public static $articleLayouts = [
        self::BASIC => 'Basic',
        self::LARGE => 'Large Feature',
    ];

    public $nullable = [];

    public $checkboxes = [
        'published',
        'is_unlisted',
        'is_in_magazine',
    ];

    public $dates = [
        'date',
        'migrated_at',
        'publish_start_date',
        'publish_end_date'
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
        'author' => [
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    /**
     * WEB-1787: See ArticleRepository for browser definitions.
     */
    public function getSponsorsAttribute()
    {
        $sponsors = $this->getRelated('sponsors');

        if (!config('aic.is_preview_mode')) {
            $sponsors = $sponsors->where('published', true);
        }

        // 'site.shared._sponsors' calls `first()` on the collection
        return $sponsors;
    }

    public function getIntroAttribute()
    {
        return $this->heading;
    }

    public function getArticleTypeAttribute()
    {
        return 'editorial';
    }

    public function getTypeAttribute()
    {
        return 'article';
    }

    public function getTrackingTitleAttribute()
    {
        return $this->title;
    }

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join('/', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('articles'), '/', $this->id, '/']);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.collection.articles_publications.articles.edit', $this->id);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_category');
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeByCategories($query, $categories = null)
    {
        if (empty($categories)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', is_array($categories) ? $categories : [$categories]);
        });
    }

    /**
     * TODO: Drop table! Made obsolete via MigrateArticleBrowsers (WEB-1183)
     */
    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }

    public static function getAllFeedItems()
    {
        return \App\Models\Article::query()->published()->notUnlisted()->orderBy('date', 'desc')->limit(300)->get();
    }

    public function toFeedItem()
    {
        $heroImage = $this->imageFront('hero');

        $ch = curl_init($heroImage['src']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        $data = curl_exec($ch);
        $length = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->heading ?? $this->list_description ?? 'Article',
            'author' => 'AIC',
            'updated' => $this->date ?? $this->updated_at, // WEB-1278: Display date
            'link' => route('articles.show', $this),
            'enclosure' => $heroImage['src'],
            'enclosureLength' => $length,
            'enclosureType' => $type,
            'category' => $this->categories->first()->name ?? '',
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
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
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
                'name' => 'is_unlisted',
                'doc' => 'Whether the article is unlisted',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_unlisted;
                }
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
                'name' => 'copy',
                'doc' => 'Copy',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                },
            ],
            [
                'name' => 'slug',
                'doc' => 'slug',
                'type' => 'string',
                'value' => function () {
                    return $this->slug;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'web_url',
                'type' => 'string',
                'value' => function () {
                    return url(route('articles.show', $this));
                },
            ],
            [
                'name' => 'subtype',
                'doc' => 'Subtype',
                'type' => 'string',
                'value' => function () {
                    return $this->subtype;
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
                'name' => 'list_description',
                'doc' => 'list_description',
                'type' => 'string',
                'value' => function () {
                    return $this->list_description;
                },
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

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Article extends AbstractModel implements Feedable
{
    use HasSlug, HasRevisions, HasMedias, HasMediasEloquent, HasApiRelations, HasBlocks, Transformable, HasRelated;

    protected $presenter = 'App\Presenters\Admin\ArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArticlePresenter';

    protected $selectedFeaturedRelated = null;

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
        'author',
        'copy',
        'subtype',
        'citation',
        'layout_type',
        'is_boosted',
        'migrated_node_id',
        'migrated_at',
        'citations',
        'meta_title',
        'meta_description',
        'publish_start_date',
        'publish_end_date',
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

    public $checkboxes = ['published', 'is_boosted'];

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
        'author' => [
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

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

    public function getTrackingSlugAttribute()
    {
        return $this->title;
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('articles'), '/', $this->id, '/']);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_category');
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeByCategory($query, $category = null)
    {
        if (empty($category)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category);
        });
    }

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }

    public function sidebarExhibitions()
    {
        return $this->apiElements()->where('relation', 'sidebarExhibitions');
    }

    public function sidebarEvent()
    {
        return $this->belongsToMany('App\Models\Event', 'article_event_sidebar')->withPivot('position')->orderBy('position');
    }

    public function sidebarArticle()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article_sidebar', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video')->withPivot('position')->orderBy('position');
    }

    public function getFeaturedRelatedAttribute()
    {
        // Select a random element from those relationships below and return one per request
        if ($this->selectedFeaturedRelated) {
            return $this->selectedFeaturedRelated;
        }

        $types = collect(['sidebarArticle', 'videos', 'sidebarExhibitions', 'sidebarEvent'])->shuffle();
        foreach ($types as $type) {
            if ($item = $this->$type()->first()) {
                switch ($type) {
                    case 'sidebarArticle':
                        $type = 'article';
                        break;
                    case 'videos':
                        $type = 'medias';
                        break;
                    case 'sidebarEvent':
                        $type = 'event';
                        break;
                    case 'sidebarExhibitions':
                        $item = $this->apiModels('sidebarExhibitions', 'Exhibition')->first();
                        $type = 'exhibition';
                        break;
                }

                $this->selectedFeaturedRelated = [
                    'type' => Str::singular($type),
                    'items' => [$item],
                ];
                return $this->selectedFeaturedRelated;
            }
        }
    }


    public static function getAllFeedItems()
    {
        return \App\Models\Article::query()->published()->orderBy('date', 'desc')->get();
    }

    public function toFeedItem()
    {
        $heroImage = $this->imageFront('hero');

        $ch = curl_init($heroImage['src']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);

        $data = curl_exec($ch);
        $length = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        return FeedItem::create([
           'id' => $this->id,
           'title' => $this->title,
           'date' => $this->present()->date,
           'summary' => $this->heading ?? $this->list_description ?? 'Article',
           'author' => $this->author ?? 'AIC',
           'updated' => $this->updated_at,
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
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'publish_start_date',
                "doc" => "Publish Start Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_start_date; }
            ],
            [
                "name" => 'publish_end_date',
                "doc" => "Publish End Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_end_date; }
            ],
            [
                "name" => 'date',
                "doc" => "Date",
                "type" => "date",
                "value" => function () {return $this->date;},
            ],
            [
                "name" => 'copy',
                "doc" => "Copy",
                "type" => "text",
                "value" => function () {return $this->blocks;},
            ],
            [
                "name" => 'is_boosted',
                "doc" => "Is Boosted",
                "type" => "boolean",
                "value" => function () {return $this->is_boosted;},
            ],
            [
                "name" => "slug",
                "doc" => "slug",
                "type" => "string",
                "value" => function () {return $this->slug;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return url(route('articles.show', $this));},
            ],
            [
                "name" => "subtype",
                "doc" => "Subtype",
                "type" => "string",
                "value" => function () {return $this->subtype;},
            ],
            [
                "name" => "heading",
                "doc" => "heading",
                "type" => "string",
                "value" => function () {return $this->heading;},
            ],
            [
                "name" => "list_description",
                "doc" => "list_description",
                "type" => "string",
                "value" => function () {return $this->list_description;},
            ],
            [
                "name" => "author",
                "doc" => "author",
                "type" => "string",
                "value" => function () {return $this->author;},
            ],
        ];
    }
}

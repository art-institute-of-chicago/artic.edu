<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class Video extends AbstractModel
{
    use HasSlug;
    use HasRevisions;
    use HasMedias;
    use HasFiles;
    use HasMediasEloquent;
    use HasRelated;
    use HasBlocks;
    use Transformable;

    protected $presenter = 'App\Presenters\Admin\VideoPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\VideoPresenter';

    protected $fillable = [
        'published',
        'date',
        'title',
        'heading',
        'video_url',
        'list_description',
        'title_display',
        'meta_title',
        'meta_description',
        'search_tags',
        'duration',
        'is_listed',
        'toggle_autorelated',
    ];

    protected $casts = [
        'date' => 'date',
        'published' => 'boolean',
        'is_listed' => 'boolean',
        'toggle_autorelated' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'is_listed' => false,
        'toggle_autorelated' => false,
    ];

    protected $appends = [
        'embed',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public $slugAttributes = [
        'title',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'video_category');
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

    public function getEmbedAttribute()
    {
        return \EmbedConverter::convertUrl($this->video_url);
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
        return join('-', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        // Workaround for the CMS, should be moved away from the model
        return join([route('videos'), '/', $this->id, '-']);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.collection.articles_publications.videos.edit', $this->id);
    }

    public function getUrlAttribute()
    {
        return route('videos.show', ['id' => $this->id, 'slug' => $this->getSlug()], false);
    }

    public function getTypeAttribute()
    {
        return 'video';
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
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
                'name' => 'video_url',
                'doc' => 'Video URL',
                'type' => 'text',
                'value' => function () {
                    return $this->video_url;
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
                'name' => 'heading',
                'doc' => 'heading',
                'type' => 'string',
                'value' => function () {
                    return $this->heading;
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

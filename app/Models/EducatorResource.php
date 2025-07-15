<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class EducatorResource extends AbstractModel
{
    use HasBlocks;
    use HasSlug;
    use HasMedias;
    use HasFiles;
    use HasRevisions;
    use HasMediasEloquent;
    use Transformable;
    use HasRelated;
    use HasTranslation;

    protected $fillable = [
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'has_media_content'
    ];

    public $translatedAttributes = [
        'title',
        'title_display',
        'listing_description',
        'short_description',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $casts = [
        'published' => 'boolean',
        'public' => 'boolean',
        'publish_start_date' => 'date',
        'publish_end_date' => 'date',
        'has_media_content' => 'boolean'
    ];

    public $attributes = [
        'published' => false,
        'public' => false,
        'has_media_content' => false
    ];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
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

    public $filesParams = ['pdf'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\ResourceCategory', 'educator_resource_resource_category', 'educator_resource_id');
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

    public function getTypeAttribute()
    {
        return 'educator_resource';
    }

    public function getSubtypeAttribute()
    {
        return 'Educator Resource';
    }

    public function getUrlWithoutSlugAttribute()
    {
        return route('collection.resources.educator-resources.show', $this->id);
    }

    public function getUrlAttribute($locale = null)
    {
        $url = url(route('collection.resources.educator-resources.show', [$this->id, $this->slug]));

        if ($locale && $locale !== app()->getLocale()) {
            $url .= '?locale=' . $locale;
        }

        return $url;
    }

    public function getAdminEditUrlAttribute()
    {
        return route('twill.collection.researchResources.educatorResources.edit', $this->id);
    }

    public function hasFileForLocale($role, $locale)
    {
        return $this->files()->where('role', $role)->where('locale', $locale)->exists();
    }

    public function scopeIds($query, $ids = []): Builder
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeOrderByDate($query): Builder
    {
        return $query->orderBy('publish_start_date', 'DESC');
    }
    public function scopeByCategory($query, $category = null): Builder
    {
        if (empty($category)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($category) {
            $query->where('resource_category_id', $category);
        });
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
                    return $this->blocks;
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

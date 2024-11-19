<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasAutoRelated;
use App\Models\Behaviors\HasFeaturedRelated;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenericPage extends AbstractModel implements Sortable
{
    use HasMediasEloquent;
    use HasAutoRelated;
    use HasRelated;
    use HasFeaturedRelated;
    use HasBlocks;
    use HasSlug;
    use HasMedias;
    use HasFiles;
    use HasRevisions;
    use HasPosition;
    use NodeTrait;
    use Transformable;
    use HasRelated;
    use HasApiRelations;
    use HasFeaturedRelated;
    use HasFactory;

    protected $fillable = [
        'short_description',
        'listing_description',
        'title',
        'title_display',
        'published',
        'position',
        'publish_start_date',
        'publish_end_date',
        'parent_id',
        'listing',
        'banner',
        'redirect_url',
        'is_redirect_url_external',
        'meta_title',
        'meta_description',
        'search_tags',
        'http_protected',
        'show_hours',
    ];

    public $casts = [
        'publish_start_date' => 'date',
        'publish_end_date' => 'date',
        'published' => 'boolean',
        'active' => 'boolean',
        'is_redirect_url_external' => 'boolean',
        'http_protected' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'is_redirect_url_external' => false,
        'http_protected' => false,
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    /**
     * Required by the HasMedias trait
     */
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
                    'ratio' => 25 / 3,
                ],
            ],
        ],
    ];

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function getDateAttribute()
    {
        if ($this->publish_start_date) {
            return $this->publish_start_date->format('M j, Y');
        }
    }

    public function getUrlAttribute()
    {
        if (!empty($this->redirect_url)) {
            return $this->redirect_url;
        }

        $url = '';

        foreach ($this->ancestors()->defaultOrder()->get() as $item) {
            $url = $url . '/' . $item->slug;
        }
        $url = $url . '/' . $this->slug;

        return $url;
    }

    public function getUrl($prefix = '')
    {
        return $prefix . '/' . $this->slug;
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.generic.genericPages.edit', $this->id);
    }

    public static function saveTreeFromIds($nodeTree)
    {
        ini_set('max_execution_time', '300');

        // Up to a certain point, it's more effecient to load all pages into memory
        $nodeModels = self::all();
        $nodeArrays = self::flattenTree($nodeTree);

        foreach ($nodeArrays as $nodeArray) {
            $nodeModel = $nodeModels->where('id', $nodeArray['id'])->first();

            if ($nodeArray['parent_id'] === null) {
                if (!$nodeModel->isRoot() || $nodeModel->position !== $nodeArray['position']) {
                    $nodeModel->position = $nodeArray['position'];
                    $nodeModel->saveAsRoot();
                }
            } else {
                if ($nodeModel->position !== $nodeArray['position'] || $nodeModel->parent_id !== $nodeArray['parent_id']) {
                    $nodeModel->position = $nodeArray['position'];
                    $nodeModel->parent_id = $nodeArray['parent_id'];
                    $nodeModel->save();
                }
            }
        }
    }

    public static function flattenTree(array $nodeTree, int $parentId = null)
    {
        $nodeArrays = [];
        $position = 0;

        foreach ($nodeTree as $node) {
            $nodeArrays[] = [
                'id' => $node['id'],
                'position' => $position++,
                'parent_id' => $parentId,
            ];

            if (count($node['children']) > 0) {
                $childArrays = self::flattenTree($node['children'], $node['id']);
                $nodeArrays = array_merge($nodeArrays, $childArrays);
            }
        }

        return $nodeArrays;
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\PageCategory');
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
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
                    return $this->slug;
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
                'name' => 'search_tags',
                'doc' => 'search_tags',
                'type' => 'string',
                'value' => function () {
                    return $this->search_tags;
                },
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                }
            ],
        ];
    }
}

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
use App\Models\Behaviors\HasFeaturedRelated;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GenericPage extends AbstractModel implements Sortable
{
    use HasMediasEloquent, HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, NodeTrait, Transformable, HasRelated, HasApiRelations, HasFeaturedRelated;

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
    ];

    public $dates = [
        'publish_start_date',
        'publish_end_date',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'is_redirect_url_external', 'http_protected'];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    /**
     * WEB-1522: Add "publication navigation" to `/journal`.
     */
    public function __construct(array $attributes = [])
    {
        if (request()->is('journal')) {
            $this->presenter = $this->presenterAdmin = 'App\Presenters\Admin\JournalPresenter';
        }

        parent::__construct(...func_get_args());
    }

    // fill this in if you use the HasMedias traits
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
        if ($this->publish_start_date)
            return $this->publish_start_date->format('M j, Y');
    }

    public function getUrlAttribute()
    {

        if (!empty($this->redirect_url)) {
            return $this->redirect_url;
        }

        $url = "";
        foreach ($this->ancestors()->defaultOrder()->get() as $item) {
            $url = $url . "/" . $item->slug;
        }
        $url = $url . "/" . $this->slug;

        return $url;
    }

    public function getUrl($prefix = "")
    {
        return $prefix . "/" . $this->slug;
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.generic.genericPages.edit', $this->id);
    }

    public static function saveTreeFromIds($nodesArray)
    {
        $parentNodes = self::find(Arr::pluck($nodesArray, 'id'));

        self::updateTreeRoots($nodesArray, $parentNodes);

        $parentNodes = self::find(Arr::pluck($nodesArray, 'id'));

        self::rebuildTree($nodesArray, $parentNodes);
    }

    public static function updateTreeRoots($nodesArray, $parentNodes)
    {
        if (is_array($nodesArray)) {
            $position = 1;
            foreach ($nodesArray as $nodeArray) {
                $node = $parentNodes->where('id', $nodeArray['id'])->first();
                $node->position = $position++;
                $node->saveAsRoot();
            }
        }
    }

    public static function rebuildTree($nodesArray, $parentNodes)
    {
        if (is_array($nodesArray)) {
            foreach ($nodesArray as $nodeArray) {
                $parent = $parentNodes->where('id', $nodeArray['id'])->first();
                if (isset($nodeArray['children']) && is_array($nodeArray['children'])) {
                    $position = 1;
                    $nodes = self::find(Arr::pluck($nodeArray['children'], 'id'));
                    foreach ($nodeArray['children'] as $child) {
                        //append the children to their (old/new)parents
                        $descendant = $nodes->where('id', $child['id'])->first();
                        $descendant->position = $position++;
                        $descendant->parent_id = $parent->id;
                        $descendant->save();
                        self::rebuildTree($nodeArray['children'], $nodes);
                    }
                }
            }
        }
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\PageCategory');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'title',
                "doc" => "Title",
                "type" => "string",
                "value" => function() { return $this->title; }
            ],
            [
                "name" => 'web_url',
                "doc" => "Web URL",
                "type" => "string",
                "value" => function() { return url($this->url); }
            ],
            [
                "name" => 'slug',
                "doc" => "Slug",
                "type" => "string",
                "value" => function() { return $this->slug; }
            ],
            [
                "name" => 'listing_description',
                "doc" => "Listing Description",
                "type" => "string",
                "value" => function() { return $this->listing_description; }
            ],
            [
                "name" => 'short_description',
                "doc" => "Short Description",
                "type" => "string",
                "value" => function() { return $this->short_description; }
            ],
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
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
                "name" => "search_tags",
                "doc" => "search_tags",
                "type" => "string",
                "value" => function () {return $this->search_tags;},
            ],
            [
                "name" => 'content',
                "doc" => "Content",
                "type" => "text",
                "value" => function() { return $this->blocks; }
            ],
        ];
    }
}

<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Behaviors\Sortable;
use A17\CmsToolkit\Models\Model;

use Kalnoy\Nestedset\NodeTrait;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasApiRelations;

class GenericPage extends Model implements Sortable
{
    use HasMediasEloquent, HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, NodeTrait, Transformable, HasApiRelations;

    protected $selectedFeaturedRelated = null;

    protected $fillable = [
        'short_description',
        'listing_description',
        'title',
        'published',
        'position',
        'publish_start_date',
        'publish_end_date',
        'parent_id',
        'listing',
        'banner',
        'redirect_url',
        'is_redirect_url_external'
    ];

    public $dates = ['publish_start_date', 'publish_end_date'];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'is_redirect_url_external'];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

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
            ]
        ],
    ];

    public function getUrlAttribute()
    {

        if (!empty($this->redirect_url)) {
            return $this->redirect_url;
        }

        $url = "";
        foreach($this->ancestors as $item) {
            $url = $url ."/".$item->slug;
        }
        $url = $url ."/".$this->slug;

        return $url;
    }

    public function getUrl($prefix="")
    {
        return $prefix."/".$this->slug;
    }

    public static function saveTreeFromIds($nodesArray)
    {
        self::updateTreeRoots($nodesArray);
        self::rebuildTree($nodesArray);
    }

    public static function updateTreeRoots($nodesArray)
    {
        if (is_array($nodesArray)) {
            $position = 1;
            foreach ($nodesArray as $nodeArray) {
                $node = self::find($nodeArray['id']);
                $node->position = $position++;
                $node->saveAsRoot();
            }
        }
    }

    public static function rebuildTree($nodesArray)
    {
        if (is_array($nodesArray)) {
            foreach ($nodesArray as $nodeArray) {
                $parent = self::find($nodeArray['id']);
                if (isset($nodeArray['children']) && is_array($nodeArray['children'])) {
                    $position = 1;
                    foreach ($nodeArray['children'] as $child) {
                        //append the children to their (old/new)parents
                        $descendant = self::find($child['id']);
                        $descendant->position = $position++;
                        $descendant->appendToNode($parent)->save();
                        self::rebuildTree($nodeArray['children']);
                    }
                }
            }
        }
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article')->withPivot('position')->orderBy('position');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\PageCategory');
    }

    public function getFeaturedRelatedAttribute()
    {
        // Select a random element from these relationships below and return one per request
        if ($this->selectedFeaturedRelated)
            return $this->selectedFeaturedRelated;

        $types = collect(['articles', 'events', 'exhibitions'])->shuffle();
        foreach ($types as $type) {
            if ($item = $this->$type()->first()) {
                switch ($type) {
                    case 'events':
                        $type = 'event';
                        break;
                    case 'articles':
                        $type = 'article';
                        break;
                    case 'exhibitions':
                        $item = $this->apiModels('exhibitions', 'Exhibition')->first();
                        $type = 'exhibition';
                        break;
                }


                $this->selectedFeaturedRelated = [
                    'type' => str_singular($type),
                    'items' => [$item]
                ];
                return $this->selectedFeaturedRelated;
            }
        }
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
                "name" => 'content',
                "doc" => "Content",
                "type" => "text",
                "value" => function() { return $this->blocks; }
            ],
        ];
    }

}

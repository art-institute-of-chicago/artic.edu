<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
// use A17\CmsToolkit\Models\Behaviors\HasTranslation;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Behaviors\Sortable;
use A17\CmsToolkit\Models\Model;

use Kalnoy\Nestedset\NodeTrait;
use App\Models\Behaviors\HasMediasEloquent;

class GenericPage extends Model implements Sortable
{
    use HasMediasEloquent, HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, NodeTrait; // HasTranslation,

    protected $fillable = [
        'short_description',
        'listing_description',
        'title',
        'published',
        'position',
        'public',
        // 'featured',
        'publish_start_date',
        'publish_end_date',
        'parent_id',
        'listing',
        'banner'
    ];

    // public $translatedAttributes = [
    //     'title',
    //     'short_description',
    //     'active',
    // ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'public'];

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
                    'ratio' => 200 / 24,
                ],
            ]
        ],
    ];

    public function getUrlAttribute()
    {
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

    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
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

    public function buildNav()
    {
        $ancestors = clone $this->ancestors;
        $rootNav = [];
        $subNav = [];

        $root = $ancestors->shift();
        $sub = $ancestors->shift();
        $forceNav = false;
        if ($sub) {
            foreach($sub->children as $item) {
                $subNav[] = ['href' => $item->url, 'label' => $item->title];
            }
        } else {
            if (sizeof($ancestors) == 0) {
                $forceNav = true;
                foreach($this->children as $item) {
                    $subNav[] = ['href' => $item->url, 'label' => $item->title];
                }
            }
        }

        if ($root) {
            foreach($root->children as $item) {
                $navItem = ['href' => $item->url, 'label' => $item->title];

                if ($sub && $item->id == $sub->id || ($forceNav && $this->id == $item->id)) {
                    $navItem['links'] = $subNav;
                }
                $rootNav[] = $navItem;

            }
        }
        $nav = array('nav' => $rootNav, 'subNav' => $subNav);

        return $nav;
    }

    public function buildBreadCrumb()
    {
        $crumbs = [];

        $ancestors = clone $this->ancestors;

        foreach($ancestors as $ancestor) {
            // dd($ancestor);
            $crumb = [];
            $crumb['label'] = $ancestor->title;
            $crumb['href'] = $ancestor->url;

            $crumbs[] = $crumb;
        }

        $crumb = [];
        $crumb['label'] = $this->title;
        $crumb['href'] = $this->url;
        $crumbs[] = $crumb;

        return $crumbs;
    }


}

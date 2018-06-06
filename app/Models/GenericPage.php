<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;
use Kalnoy\Nestedset\NodeTrait;

class GenericPage extends Model implements Sortable
{
    use HasMediasEloquent, HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasPosition, NodeTrait;

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
        'is_redirect_url_external',
    ];

    public $dates = ['publish_start_date', 'publish_end_date'];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'is_redirect_url_external'];

    protected $presenter = 'App\Presenters\Admin\GenericListingPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericListingPresenter';

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

    public function getUrlAttribute()
    {

        if (!empty($this->redirect_url)) {
            return $this->redirect_url;
        }

        $url = "";
        foreach ($this->ancestors as $item) {
            $url = $url . "/" . $item->slug;
        }
        $url = $url . "/" . $this->slug;

        return $url;
    }

    public function getUrl($prefix = "")
    {
        return $prefix . "/" . $this->slug;
    }

    public static function saveTreeFromIds($nodesArray)
    {
        $parentNodes = self::find(array_pluck($nodesArray, 'id'));

        self::updateTreeRoots($nodesArray, $parentNodes);

        $parentNodes = self::find(array_pluck($nodesArray, 'id'));

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
                    $nodes = self::find(array_pluck($nodeArray['children'], 'id'));
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
            foreach ($sub->children as $item) {
                $subNav[] = ['href' => $item->url, 'label' => $item->title];
            }
        } else {
            if (sizeof($ancestors) == 0) {
                $forceNav = true;
                foreach ($this->children as $item) {
                    $subNav[] = ['href' => $item->url, 'label' => $item->title];
                }
            }
        }

        if ($root) {
            foreach ($root->children as $item) {
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

        foreach ($ancestors as $ancestor) {
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

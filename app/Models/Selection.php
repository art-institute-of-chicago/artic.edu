<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasApiRelations;

use App\Models\Api\Artwork;

class Selection extends Model
{
    use HasSlug, HasMedias, HasBlocks, HasApiRelations, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\SelectionPresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'short_copy',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getIntroAttribute()
    {
        return $this->short_copy;
    }

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article')->withPivot('position')->orderBy('position');
    }

    public function getArtworkImages($count = 5)
    {
        $list = collect([]);

        $artwork_ids = collect([]);
        foreach($this->blocks as $block) {
            if ($block->type == 'artwork') {
                if (isset($block->content['browsers'])) {
                    if (isset($block->content['browsers']['artworks'])) {
                        $ids = $block->content['browsers']['artworks'];
                        foreach($ids as $id) {
                            $artwork_ids->push($id);
                        }
                    }
                }
            } else if ($block->type == 'artworks') {
                if (isset($block->content['browsers'])) {
                    if (isset($block->content['browsers']['artworks'])) {
                        $ids = $block->content['browsers']['artworks'];
                        foreach($ids as $id) {
                            $artwork_ids->push($id);
                        }

                    }
                }
            }
        }

        // load artworks and get the images
        $artworks = Artwork::query()->ids($artwork_ids->toArray())->get();
        foreach($artworks as $artwork) {
            if ($artwork->imageFront()) {
                $list[] = $artwork->imageFront();
            }

            if ($list->count() >= $count) {
                break;
            }
        }

        return $list;
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],
            [
                "name" => 'updated_at',
                "doc" => "Updated",
                "type" => "date",
                "value" => function() { return $this->updated_at; }
            ],
            [
                "name" => 'content',
                "doc" => "Content",
                "type" => "text",
                "value" => function() { return $this->blocks; }
            ],
            [
                "name" => 'short_copy',
                "doc" => "Short Copy",
                "type" => "text",
                "value" => function() { return $this->short_copy; }
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
                "value" => function () {return url(route('selections.show', $this));},
            ],
        ];
    }

}

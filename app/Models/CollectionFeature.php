<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class CollectionFeature extends AbstractModel
{

    /**
     * TODO: Why does this have HasMediasEloquent?
     */
    use HasBlocks, HasApiRelations, HasMediasEloquent;

    protected $fillable = [
        'title',
        'published',
        'publish_start_date',
        'publish_end_date',
    ];

    public $checkboxes = ['published'];

    public function articles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'article_collection_feature', 'collection_feature_id', 'article_id')->withPivot('position')->orderBy('position');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }

    public function selections()
    {
        return $this->belongsToMany(\App\Models\Selection::class, 'collection_feature_selection', 'collection_feature_id', 'selection_id')->withPivot('position')->orderBy('position');
    }

    public function enclosedItem()
    {
        $item = $this->articles->first();
        $item = $item ?? $this->selections->first();
        $item = $item ?? $this->apiModels('artworks', 'Artwork')->first();

        if (!$item) {
            return null;
        }

        if ($item->type == 'artwork') {
            $item->subtype = 'Artwork';
        }

        if ($item->type == 'article') {
            $item->subtype = 'Article';
        }

        $item->trackingTitle = getUtf8Slug($item->title);

        return $item;
    }

}

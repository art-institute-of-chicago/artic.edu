<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

use A17\CmsToolkit\Models\Model;

class CollectionFeature extends Model
{

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

}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class HomeFeature extends Model
{
    use HasMedias, HasBlocks, HasApiRelations, HasMediasEloquent, HasFiles;

    protected $fillable = [
        'title',
        'published',
        'publish_start_date',
        'publish_end_date',
    ];

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateHomeFeature::class,
        'deleted' => \App\Events\UpdateHomeFeature::class,
    ];

    // fill this in if you use the HasMedias traits
    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];
    public $filesParams = ['video']; // a list of file roles

    public $checkboxes = ['published'];

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_home_feature', 'home_feature_id', 'event_id')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'article_home_feature', 'home_feature_id', 'article_id')->withPivot('position')->orderBy('position');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }
}

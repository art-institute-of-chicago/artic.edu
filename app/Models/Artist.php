<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class Artist extends Model
{
    use HasSlug, HasApiModel, HasMedias, HasApiRelations, HasMediasEloquent, Transformable;

    protected $apiModel = 'App\Models\Api\Artist';

    protected $fillable = [
        'intro',
        'datahub_id',
        'title',
        'caption',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_artist')->withPivot('position')->orderBy('position');
    }

    public function featuredArtworks()
    {
        return $this->apiElements()->where('relation', 'featuredArtworks');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'intro_copy',
                "doc" => "Intro Copy",
                "type" => "string",
                "value" => function () {return $this->intro_copy;},
            ],
            [
                "name" => 'datahub_id',
                "doc" => "Type",
                "type" => "string",
                "value" => function () {return $this->datahub_id;},
            ],
        ];
    }

}

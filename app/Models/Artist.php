<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class Artist extends AbstractModel
{
    use HasSlug, HasApiModel, HasApiRelations, HasMedias, HasMediasEloquent, Transformable, HasRelated;

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
                    'ratio' => 'default',
                ],
            ],
        ],
    ];

    public function featuredArtworks()
    {
        return $this->apiElements()->where('relation', 'featuredArtworks');
    }

    public function getSlugAttribute()
    {
        return ['en' => getUtf8Slug($this->title)];
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'intro',
                "doc" => "Intro Copy",
                "type" => "string",
                "value" => function () {return $this->intro;},
            ],
            [
                "name" => 'datahub_id',
                "doc" => "Data Hub ID",
                "type" => "string",
                "value" => function () {return $this->datahub_id;},
            ],
            [
                "name" => 'related',
                "doc" => "Related Content",
                "type" => "array",
                "value" => function () { return $this->transformRelated(); },
            ],
        ];
    }

}

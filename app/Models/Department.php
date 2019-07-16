<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class Department extends AbstractModel
{
    use HasApiModel, Transformable, HasMedias, HasApiRelations, HasMediasEloquent;

    protected $apiModel = 'App\Models\Api\Department';

    protected $fillable = [
        'datahub_id',
        'intro',
        'caption',
        'meta_title',
        'meta_description',
        'should_append_artworks',
        'max_artworks',
    ];

    public $checkboxes = [
        'should_append_artworks',
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

    public function customRelatedArtworks()
    {
        return $this->apiElements()->where('relation', 'customRelatedArtworks');
    }

    public function getSlugAttribute()
    {
        return ['en' => getUtf8Slug($this->title)];
    }

}

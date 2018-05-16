<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasApiRelations;

use App\Models\Behaviors\HasApiModel;

class Department extends Model
{
    use HasApiModel, Transformable, HasMedias, HasApiRelations;

    protected $apiModel = 'App\Models\Api\Department';

    protected $fillable = [
        'datahub_id',
        'intro',
        'caption'
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
            ]
        ],
    ];

    // public function artworks()
    // {
    //     return $this->apiElements()->where('relation', 'artworks');
    // }
}

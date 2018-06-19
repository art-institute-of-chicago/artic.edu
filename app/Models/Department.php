<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class Department extends Model
{
    use HasApiModel, Transformable, HasMedias, HasApiRelations, HasMediasEloquent;

    protected $apiModel = 'App\Models\Api\Department';

    protected $fillable = [
        'datahub_id',
        'intro',
        'caption',
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

    // public function artworks()
    // {
    //     return $this->apiElements()->where('relation', 'artworks');
    // }
}

<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class CategoryTerm extends AbstractModel
{
    use HasApiModel, Transformable, HasMedias, HasMediasEloquent, HasApiRelations;

    protected $apiModel = 'App\Models\Api\CategoryTerm';

    protected $fillable = [
        'datahub_id',
        'local_subtype',
        'local_title',
    ];

    public $mediasParams = [
        'thumb' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];
}

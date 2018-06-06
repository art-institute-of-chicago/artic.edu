<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class CategoryTerm extends Model
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

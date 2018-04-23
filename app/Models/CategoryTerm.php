<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasApiRelations;

class CategoryTerm extends Model
{
    use HasApiModel, Transformable, HasMedias, HasMediasEloquent, HasApiRelations;

    protected $apiModel = 'App\Models\Api\CategoryTerm';

    protected $fillable = [
        'datahub_id',
        'local_subtype',
        'local_title'
    ];

    public $mediasParams = [
        'thumb' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ]
        ],
    ];

}

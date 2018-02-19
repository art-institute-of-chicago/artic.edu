<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;

class Gallery extends Model
{
    use HasApiModel, Transformable;

    protected $apiModel = 'App\Models\Api\Gallery';

    protected $fillable = [
        'datahub_id',
        'intro'
    ];

    public $slugAttributes = [
        'title',
    ];
}

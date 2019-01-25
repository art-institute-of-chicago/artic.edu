<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;

class ResourceCategory extends AbstractModel
{
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    public $slugAttributes = [
        'name',
    ];
}

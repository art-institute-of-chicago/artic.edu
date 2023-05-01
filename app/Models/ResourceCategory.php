<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasPosition;

class ResourceCategory extends AbstractModel
{
    use HasSlug;
    use HasPosition;

    protected $fillable = [
        'name',
    ];

    public $slugAttributes = [
        'name',
    ];
}

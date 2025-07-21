<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResourceCategory extends AbstractModel
{
    use HasSlug;
    use HasPosition;
    use HasFactory;

    protected $fillable = [
        'name',
        'type'
    ];

    public $slugAttributes = [
        'name',
    ];
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;

class CatalogCategory extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
    ];

    public $slugAttributes = [
        'name',
    ];
}

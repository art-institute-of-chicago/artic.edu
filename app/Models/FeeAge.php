<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Model;

class FeeAge extends Model
{
    use HasPosition;

    protected $fillable = [
        'title',
        'position',
    ];
}

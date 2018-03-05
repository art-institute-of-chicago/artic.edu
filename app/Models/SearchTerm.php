<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Behaviors\Sortable;

class SearchTerm extends Model implements Sortable
{
    use HasPosition;

    protected $fillable = [
        'name',
        'position'
    ];
}

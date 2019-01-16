<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

class SearchTerm extends AbstractModel implements Sortable
{
    use HasPosition;

    protected $fillable = [
        'name',
        'position',
        'direct_url',
    ];
}

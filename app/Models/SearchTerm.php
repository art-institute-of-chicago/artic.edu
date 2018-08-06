<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class SearchTerm extends Model implements Sortable
{
    use HasPosition;

    protected $fillable = [
        'name',
        'position',
        'direct_url',
    ];
}

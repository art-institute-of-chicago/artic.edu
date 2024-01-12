<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class WhatToExpect extends Model implements Sortable
{
    use HasRevisions;
    use HasPosition;

    protected $fillable = [
        'published',
        'icon_type',
        'position',
        'page_id',
        'landing_page_id',
        'text',
    ];

    public $casts = [
        'published' => 'boolean',
    ];
}

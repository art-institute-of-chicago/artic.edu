<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class WhatToExpect extends Model implements Sortable
{
    use HasTranslation, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'icon_type',
        'position',
        'page_id'
    ];

    public $translatedAttributes = [
        'text',
    ];

    /**
     * Add checkbox fields names here (published toggle is itself a checkbox)
     */
    public $checkboxes = [
        'published'
    ];

}

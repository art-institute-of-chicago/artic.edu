<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

class Question extends AbstractModel implements Sortable
{
    use HasPosition;

    protected $fillable = [
        'published',
        'question',
        'answer',
        'position',
    ];

    /**
     * Those fields get auto set to null if not submited
     */
    public $nullable = [];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];
}

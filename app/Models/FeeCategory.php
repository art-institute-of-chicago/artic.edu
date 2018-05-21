<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;

class FeeCategory extends Model
{
    use HasPosition;

    protected $fillable = [
        'title',
        'tooltip',
        'position',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];
}

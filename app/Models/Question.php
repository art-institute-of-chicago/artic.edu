<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasPosition;

class Question extends Model
{
    use HasPosition;

    protected $fillable = [
        'published',
        'question',
        'answer',
        'position'
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];
}

<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Behaviors\Sortable;
use A17\CmsToolkit\Models\Model;

class Question extends Model implements Sortable
{
    use HasPosition;

    protected $fillable = [
        'published',
        'question',
        'answer',
        'position',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];
}

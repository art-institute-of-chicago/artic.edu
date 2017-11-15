<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;

class CategorySegment extends Model
{
    protected $fillable = [
        'published',
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    // fill this in if you use the HasMedias traits
    // public $mediasParams = [];

    // fill this in if you use the HasFiles traits
    // public $filesParams = [];
}

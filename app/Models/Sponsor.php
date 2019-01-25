<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;

class Sponsor extends AbstractModel
{
    use HasBlocks;

    protected $fillable = [
        'published',
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];
}

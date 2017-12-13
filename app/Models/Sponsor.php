<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasMedias;

class Sponsor extends Model
{
    use HasMedias;

    protected $fillable = [
        'published',
        'title',
        'copy',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public $mediasParams = [
        'logo' => [
            'default' => '1',
        ]
    ];
}

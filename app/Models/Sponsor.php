<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;

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
    public $checkboxes = ['published'];

    public $mediasParams = [
        'profile' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];
}

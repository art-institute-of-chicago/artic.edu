<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasPosition;
use A17\CmsToolkit\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasMediasEloquent;
use A17\CmsToolkit\Models\Model;

class Offer extends Model implements Sortable
{
    use HasMedias, HasMediasEloquent, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'description',
        'price',
        'url',
        'label',
        'position',
        'exhibition_id',
    ];

    // fill this in if you use the HasMedias traits
    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ]
        ],
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];
}

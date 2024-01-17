<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class Offer extends AbstractModel implements Sortable
{
    use HasMedias;
    use HasMediasEloquent;
    use HasPosition;

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

    /**
     * Required by the HasMedias traits
     */
    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];
}

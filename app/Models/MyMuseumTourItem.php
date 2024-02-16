<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class MyMuseumTourItem extends Model
{
    use HasBlocks;
    use HasSlug;
    use HasMedias;
    use HasFiles;
    use HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'tour_id',
        'teaser_text',
        'artwork_count'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $mediasParams = [
        'teaser_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];
}

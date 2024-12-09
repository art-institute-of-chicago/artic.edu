<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasMedias;
use App\Helpers\StringHelpers;

class Gallery extends AbstractModel
{
    use HasApiModel;
    use Transformable;
    use HasMedias;

    protected $apiModel = 'App\Models\Api\Gallery';

    protected $fillable = [
        'datahub_id',
        'intro',
        'caption',
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public function getSlugAttribute(): string
    {
        return StringHelpers::getUtf8Slug($this->title);
    }
}

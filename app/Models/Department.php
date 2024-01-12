<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Helpers\StringHelpers;

class Department extends AbstractModel
{
    use HasApiModel;
    use Transformable;
    use HasMedias;
    use HasApiRelations;
    use HasMediasEloquent;
    use HasRelated;

    protected $apiModel = 'App\Models\Api\Department';

    protected $fillable = [
        'datahub_id',
        'intro',
        'caption',
        'meta_title',
        'meta_description',
        'pinboard_title',
        'should_append_artworks',
        'max_artworks',
    ];

    public $casts = [
        'should_append_artworks' => 'boolean',
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

    public function customRelatedArtworks()
    {
        return $this->apiElements()->where('relation', 'customRelatedArtworks');
    }

    public function getSlugAttribute()
    {
        return ['en' => StringHelpers::getUtf8Slug($this->title)];
    }
}

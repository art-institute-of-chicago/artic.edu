<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasRelated;
use App\Models\Page;
use Carbon\Carbon;

class InteractiveFeature
 extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable, HasRelated;

    protected $apiModel = 'App\Models\Api\DigitalLabel';

    protected $fillable = [
        'content',
        'published',
        'title',
        'sub_title',
        'archived',
        'grouping_background_color',
        'color',
    ];

    protected $casts = [
        'updated_at' => 'string',
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
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
                ],
            ],
        ],
    ];

    public $type = 'label';
    public $checkboxes = ['published'];

    public function experiences()
    {
        return $this->hasMany('App\Models\Experience', 'interactive_feature_id');
    }

    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    public function scopeUnarchived($query)
    {
        return $query->where('archived', false);
    }
}

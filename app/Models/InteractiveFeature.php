<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasRelated;
use App\Models\Page;
use Carbon\Carbon;

class InteractiveFeature extends AbstractModel
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiRelations, Transformable, HasRelated;

    //protected $apiModel = 'App\Models\Api\DigitalLabel';

    protected $presenter = 'App\Presenters\Admin\InteractiveFeaturePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\InteractiveFeaturePresenter';

    protected $fillable = [
        'content',
        'published',
        'title',
        'sub_title',
        'archived',
        'grouping_background_color',
        'color',
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

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'title',
                "doc" => "Title",
                "type" => "string",
                "value" => function () {return $this->title;},
            ],
            [
                "name" => 'sub_title',
                "doc" => "Sub-title",
                "type" => "string",
                "value" => function () {return $this->sub_title;},
            ],
            [
                "name" => 'grouping_background_color',
                "doc" => "Grouping background color",
                "type" => "string",
                "value" => function () {return $this->grouping_background_color;},
            ],
            [
                "name" => 'color',
                "doc" => "Color",
                "type" => "string",
                "value" => function () {return $this->color;},
            ],
            [
                "name" => 'archived',
                "doc" => "Archived",
                "type" => "boolean",
                "value" => function () {return $this->archived;},
            ],
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
        ];
    }
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Page;
use Carbon\Carbon;

class DigitalLabel extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable;

    protected $apiModel = 'App\Models\Api\DigitalLabel';

    // protected $dispatchesEvents = [
    //     'saved' => \App\Events\UpdateDigitalLabel::class,
    //     'deleted' => \App\Events\UpdateDigitalLabel::class,
    // ];

    protected $fillable = [
        'content',
        'published',
        'title',
        'datahub_id',
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

    public function getUrl()
    {
        return route('digitalLabels.show', ['id' => $this->datahub_id, 'slug' => str_slug($this->title, '-')]);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'datahub_id',
                "doc" => "Type",
                "type" => "string",
                "value" => function () {return $this->datahub_id;},
            ],
            [
                "name" => 'image_url',
                "doc" => "Image URL",
                "type" => "string",
                "value" => function () {return starts_with($this->image('image'), 'http') ? $this->image('image') : null;},
            ],
        ];
    }

    public function experiences()
    {
        return $this->hasMany('App\Models\Experience', 'digital_label_id');
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

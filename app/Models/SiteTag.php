<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;

class SiteTag extends AbstractModel
{
    use HasSlug, Transformable;

    protected $fillable = [
        'name',
    ];

    public $slugAttributes = [
        'name',
    ];

    public function segments()
    {
        return $this->morphToMany(\App\Models\Segment::class, 'segmentable');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'name',
                'doc' => 'Name of this tag',
                'type' => 'string',
                'value' => function () {
                    return $this->name;
                },
            ],
        ];
    }
}

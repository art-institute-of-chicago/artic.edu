<?php

namespace App\Models;

use App\Models\Behaviors\HasBlocks;

class Sponsor extends AbstractModel
{
    use HasBlocks;
    use Transformable;

    protected $fillable = [
        'published',
        'title',
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

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'string',
                'value' => function () {
                    return $this->renderBlocks();
                }
            ],
        ];
    }
}

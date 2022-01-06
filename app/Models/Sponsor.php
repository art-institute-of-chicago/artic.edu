<?php

namespace App\Models;

use App\Models\Behaviors\HasBlocks;

class Sponsor extends AbstractModel
{
    use HasBlocks, Transformable;

    protected $fillable = [
        'published',
        'title',
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    /**
     * Those fields get auto set to false if not submitted
     */
    public $checkboxes = ['published'];

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

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;

class Sponsor extends AbstractModel
{
    use HasBlocks, Transformable;

    protected $fillable = [
        'published',
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "title",
                "doc" => "Title",
                "type" => "string",
                "value" => function () {return $this->title;},
            ],
            [
                "name" => "published",
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'content',
                "doc" => "Content",
                "type" => "string",
                "value" => function() { return $this->renderBlocks(); }
            ],
        ];
    }
}

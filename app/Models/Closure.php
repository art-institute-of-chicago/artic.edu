<?php

namespace App\Models;

use A17\Twill\Models\Model;

class Closure extends Model
{
    use Transformable;

    protected $presenter = 'App\Presenters\ClosurePresenter';
    protected $presenterAdmin = 'App\Presenters\ClosurePresenter';

    protected $fillable = [
        'published',
        'date_start',
        'date_end',
        'closure_copy',
        'type',
    ];

    public static $types = [
        0 => 'Museum',
        1 => 'Shop',
        2 => 'Library',
    ];

    public $nullable = [];

    public $checkboxes = ['published'];

    public $dates = ['date_start', 'date_end'];

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'date_start',
                "doc" => "Start of closure",
                "type" => "date",
                "value" => function () {return $this->date_start;},
            ],
            [
                "name" => 'date_end',
                "doc" => "End of closure",
                "type" => "date",
                "value" => function () {return $this->date_end;},
            ],
            [
                "name" => 'closure_copy',
                "doc" => "Description of Closure",
                "type" => "text",
                "value" => function () {return $this->closure_copy;},
            ],
            [
                "name" => 'type',
                "doc" => "Type of Closure",
                "type" => "number",
                "value" => function () {return $this->type;},
            ],
        ];
    }

}

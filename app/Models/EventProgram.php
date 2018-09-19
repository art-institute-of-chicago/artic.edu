<?php

namespace App\Models;

use A17\Twill\Models\Model;

class EventProgram extends Model
{

    use Transformable;

    protected $fillable = [
        'name',
    ];

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "name",
                "doc" => "Name",
                "type" => "string",
                "value" => function () {return $this->name;},
            ],
        ];
    }
}

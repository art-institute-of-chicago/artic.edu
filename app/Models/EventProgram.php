<?php

namespace App\Models;


class EventProgram extends AbstractModel
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

<?php

namespace App\Models;


class EventProgram extends AbstractModel
{

    use Transformable;

    protected $fillable = [
        'name',
        'is_affiliate_group',
    ];

    protected $casts = [
        'is_affiliate_group' => 'boolean',
    ];

    protected $presenter = 'App\Presenters\Admin\EventProgramPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\EventProgramPresenter';

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "name",
                "doc" => "Name",
                "type" => "string",
                "value" => function () {return $this->name;},
            ],
            [
                "name" => "is_affiliate_group",
                "doc" => "Is Affiliate Group",
                "type" => "boolean",
                "value" => function () {return $this->is_affiliate_group;},
            ],
        ];
    }
}

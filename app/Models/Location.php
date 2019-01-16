<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;

class Location extends AbstractModel
{
    use Transformable, HasTranslation;

    protected $fillable = [
        'published',
        'street',
        'address',
        'city',
        'state',
        'zip',
        'position',
        'page_id',
    ];

    public $translatedAttributes = [
        'name',
    ];

    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'name',
                "doc" => "Name of this location",
                "type" => "string",
                "value" => function () {return $this->name;},
            ],
            [
                "name" => 'street',
                "doc" => "Street of this location",
                "type" => "string",
                "value" => function () {return $this->street;},
            ],
            [
                "name" => 'address',
                "doc" => "Address of this location",
                "type" => "string",
                "value" => function () {return $this->address;},
            ],
            [
                "name" => 'address',
                "doc" => "Address of this location",
                "type" => "string",
                "value" => function () {return $this->address;},
            ],
            [
                "name" => 'city',
                "doc" => "City of this location",
                "type" => "string",
                "value" => function () {return $this->city;},
            ],
            [
                "name" => 'state',
                "doc" => "State of this location",
                "type" => "string",
                "value" => function () {return $this->state;},
            ],
            [
                "name" => 'zip',
                "doc" => "Zip of this location",
                "type" => "string",
                "value" => function () {return $this->zip;},
            ],
            [
                "name" => 'published',
                "doc" => "Published status this location",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return '/#todo';},
            ],
        ];
    }

}

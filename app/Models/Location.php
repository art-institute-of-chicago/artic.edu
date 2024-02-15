<?php

namespace App\Models;

class Location extends AbstractModel
{
    use Transformable;

    protected $fillable = [
        'published',
        'street',
        'address',
        'city',
        'state',
        'zip',
        'position',
        'page_id',
        'landing_page_id',
        'name',
        'directions_link'
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'name',
                'doc' => 'Name of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->name;
                },
            ],
            [
                'name' => 'street',
                'doc' => 'Street of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->street;
                },
            ],
            [
                'name' => 'address',
                'doc' => 'Address of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->address;
                },
            ],
            [
                'name' => 'address',
                'doc' => 'Address of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->address;
                },
            ],
            [
                'name' => 'city',
                'doc' => 'City of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->city;
                },
            ],
            [
                'name' => 'state',
                'doc' => 'State of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->state;
                },
            ],
            [
                'name' => 'zip',
                'doc' => 'Zip of this location',
                'type' => 'string',
                'value' => function () {
                    return $this->zip;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published status this location',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'web_url',
                'type' => 'string',
                'value' => function () {
                    return '/#todo';
                },
            ],
        ];
    }
}

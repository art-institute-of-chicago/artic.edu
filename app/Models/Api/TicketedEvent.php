<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class TicketedEvent extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/ticketed-events',
        'resource'   => '/api/v1/ticketed-events/{id}',
        'search'     => '/api/v1/ticketed-events/search'
    ];

    public function getTitleInBrowserAttribute()
    {
        return "{$this->title} (#{$this->id})";
    }

}

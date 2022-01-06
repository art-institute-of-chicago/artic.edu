<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class TicketedEventType extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/ticketed-event-types',
        'resource' => '/api/v1/ticketed-event-types/{id}',
    ];

    public function getTitleInBrowserAttribute()
    {
        return "{$this->title} (#{$this->id})";
    }
}

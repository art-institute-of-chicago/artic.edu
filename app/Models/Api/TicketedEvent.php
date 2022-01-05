<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

use Carbon\Carbon;

class TicketedEvent extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/ticketed-events',
        'resource' => '/api/v1/ticketed-events/{id}',
        'search' => '/api/v1/ticketed-events/search'
    ];

    public function getCmsTitleAttribute()
    {
        return "{$this->title} (" . ($this->start_at ? Carbon::parse($this->start_at)->toFormattedDateString() . ', ' : '') . "#{$this->id})";
    }
}

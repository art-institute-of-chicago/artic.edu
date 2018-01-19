<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Event extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/events',
        'resource'   => '/api/v1/events/{id}',
        'search'     => '/api/v1/events/search'
    ];

    protected $augmentedModelClass = 'App\Models\Event';

    public function exhibitions()
    {
        return $this->hasMany(\App\Models\Api\Exhibition::class, 'exhibition_ids');
    }
}

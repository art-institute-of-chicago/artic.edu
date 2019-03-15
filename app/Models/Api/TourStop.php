<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class TourStop extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/tour-stops',
        'resource'   => '/api/v1/tour-stops/{id}',
        'search'     => '/api/v1/tour-stops/search'
    ];
}

<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class TourStop extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/mobile-sounds',
        'resource'   => '/api/v1/mobile-sounds/{id}',
        'search'     => '/api/v1/mobile-sounds/search'
    ];
}

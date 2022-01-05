<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Place extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/places',
        'search' => '/api/v1/places/search'
    ];
}

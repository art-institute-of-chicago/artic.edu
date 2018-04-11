<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Video extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/videos',
        'resource'   => '/api/v1/videos/{id}',
        'search'     => '/api/v1/videos/search'
    ];
}

<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Artist extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artists',
        'resource'   => '/api/v1/artists/{id}',
        'search'     => '/api/v1/artists/search'
    ];

    protected $augmentedModelClass = 'App\Models\Artist';
}

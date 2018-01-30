<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Artist extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/agents',
        'resource'   => '/api/v1/agents/{id}',
        'search'     => '/api/v1/agents/search'
    ];

    protected $augmentedModelClass = 'App\Models\Artist';
}

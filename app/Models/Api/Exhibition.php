<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Exhibition extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource'   => '/api/v1/exhibitions/{id}',
        'search'     => '/api/v1/exhibitions/search'
    ];

    protected $augmentedModelClass = 'App\Models\Exhibition';
}

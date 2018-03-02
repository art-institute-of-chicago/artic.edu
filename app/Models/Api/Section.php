<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Section extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/sections',
        'resource'   => '/api/v1/sections/{id}',
        'search'     => '/api/v1/products/search'
    ];

}

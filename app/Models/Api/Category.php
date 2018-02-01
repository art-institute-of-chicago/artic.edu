<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Category extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/categories',
        'resource'   => '/api/v1/categories/{id}',
        'search'     => '/api/v1/categories/search'
    ];
}

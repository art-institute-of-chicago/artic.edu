<?php

namespace App\Models;

use App\Libraries\Api\Models\BaseApiModel;

class CategoryApi extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/categories',
        'resource'   => '/api/v1/categories/{id}',
        'search'     => '/api/v1/categories/search'
    ];
}

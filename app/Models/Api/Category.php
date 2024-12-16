<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class Category extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/categories',
        'resource' => '/api/v1/categories/{id}',
        'search' => '/api/v1/categories/search'
    ];
}

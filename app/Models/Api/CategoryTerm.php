<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class CategoryTerm extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/category-terms',
        'search'     => '/api/v1/category-terms/search'
    ];
}

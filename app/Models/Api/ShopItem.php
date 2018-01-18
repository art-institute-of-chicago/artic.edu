<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class ShopItem extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/products',
        'resource'   => '/api/v1/products/{id}',
        'search'     => '/api/v1/products/search'
    ];

}

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

    public function categories()
    {
        return $this->hasMany(\App\Models\Api\Category::class, 'category_ids');
    }

    public function getSlugAttribute()
    {
        return $this->link;
    }
}

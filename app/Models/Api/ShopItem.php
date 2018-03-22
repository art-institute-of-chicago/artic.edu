<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Models\Behaviors\HasMediasApi;

class ShopItem extends BaseApiModel
{
    use HasMediasApi;

    protected $endpoints = [
        'collection' => '/api/v1/products',
        'resource'   => '/api/v1/products/{id}',
        'search'     => '/api/v1/products/search'
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                'field'  => 'image_id',
            ],
            'thumbnail' => [
                'field'  => 'image_id',
            ],
        ],
    ];


    public function imageFront($role = 'hero', $crop = null)
    {
        if (!empty($this->image_url)) {
            return aic_convertFromImageProxy($this->image_url);
        }
    }

    public function categories()
    {
        return $this->hasMany(\App\Models\Api\Category::class, 'category_ids');
    }

    public function getSlugAttribute()
    {
        return $this->link;
    }

    public function getCurrencyAttribute()
    {
        // Added for future updates.
        return '$';
    }
}

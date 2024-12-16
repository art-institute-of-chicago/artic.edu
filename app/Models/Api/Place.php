<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class Place extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/places',
        'search' => '/api/v1/places/search'
    ];
}

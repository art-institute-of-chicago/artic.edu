<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class Video extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/videos',
        'resource' => '/api/v1/videos/{id}',
        'search' => '/api/v1/videos/search'
    ];
}

<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class Section extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/sections',
        'resource' => '/api/v1/sections/{id}',
        'search' => '/api/v1/sections/search'
    ];
}

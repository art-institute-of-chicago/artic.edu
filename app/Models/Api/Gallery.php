<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Gallery extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/galleries',
        'resource'   => '/api/v1/galleries/{id}',
        'search'     => '/api/v1/galleries/search'
    ];
}

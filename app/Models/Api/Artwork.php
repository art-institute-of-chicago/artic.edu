<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Artwork extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artworks',
        'resource'   => '/api/v1/artworks/{id}',
        'search'     => '/api/v1/artworks/search'
    ];

    protected $augmentedModelClass = 'App\Models\Artwork';
}

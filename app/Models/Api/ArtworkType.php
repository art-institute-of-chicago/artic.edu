<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class ArtworkType extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artwork-types',
        'resource' => '/api/v1/artwork-types/{id}',
        'search' => '/api/v1/artwork-types/search',
    ];

    protected $presenter = 'App\Presenters\Admin\ArtworkTypePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArtworkTypePresenter';

    public function getParameterName()
    {
        return 'artwork_type_id';
    }
}

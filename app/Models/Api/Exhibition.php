<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class Exhibition extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource'   => '/api/v1/exhibitions/{id}',
        'search'     => '/api/v1/exhibitions/search'
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'last_updated' => 'datetime'
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Exhibition';

    protected $presenterAdmin      = 'App\Presenters\Admin\ExhibitionPresenter';

}

<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;

class TourStop extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/mobile-sounds',
        'resource' => '/api/v1/mobile-sounds/{id}',
        'search' => '/api/v1/mobile-sounds/search'
    ];

    protected $presenter = 'App\Presenters\Admin\TourStopPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\TourStopPresenter';
}

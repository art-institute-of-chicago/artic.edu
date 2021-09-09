<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class WaitTime extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/wait-times',
        'resource' => '/api/v1/wait-times/{id}',
    ];

    protected $presenter = 'App\Presenters\Admin\WaitTimePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\WaitTimePresenter';
}

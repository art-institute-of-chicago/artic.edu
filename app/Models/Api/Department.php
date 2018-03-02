<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class Department extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/departments',
        'resource'   => '/api/v1/departments/{id}',
        'search'     => '/api/v1/departments/search'
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Department';

    protected $presenter       = 'App\Presenters\Admin\DepartmentPresenter';
    protected $presenterAdmin  = 'App\Presenters\Admin\DepartmentPresenter';
}

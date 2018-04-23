<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class CategoryTerm extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/category-terms',
        'resource'   => '/api/v1/category-terms/{id}',
        'search'     => '/api/v1/category-terms/search'
    ];

    protected $presenter       = 'App\Presenters\Admin\CategoryTermPresenter';
    protected $presenterAdmin  = 'App\Presenters\Admin\CategoryTermPresenter';

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\CategoryTerm';
}

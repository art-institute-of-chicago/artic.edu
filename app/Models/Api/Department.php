<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use App\Models\Api\Search;

class Department extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/departments',
        'resource' => '/api/v1/departments/{id}',
        'search' => '/api/v1/departments/search',
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Department';

    protected $presenter = 'App\Presenters\Admin\DepartmentPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\DepartmentPresenter';

    public function getTitleSlugAttribute()
    {
        return getUtf8Slug($this->title);
    }

    public function artworks($perPage = 20)
    {
        return Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search')
            ->byDepartments($this->title)
            ->aggregationClassifications(3)
            ->getSearch($perPage);
    }
}

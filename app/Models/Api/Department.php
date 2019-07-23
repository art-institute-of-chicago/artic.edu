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

    /**
     * TODO: Obsolete code, delete? See WEB-1169, WEB-1181.
     * Now in App\Repositories\Api\DepartmentRepository
     * Would also be used for "Explore Further" via controller,
     * but that functionality is disabled for departments.
     */
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

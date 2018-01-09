<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Admin\ApiRepository;

use App\Models\SiteTagApi;

class SiteTagApiRepository extends ApiRepository
{
    use HandleSlugs;

    protected $endpoint = '/api/v1/categories';

    public function __construct(SiteTagApi $model)
    {
        $this->model = $model;
    }

}

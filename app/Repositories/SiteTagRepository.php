<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\SiteTag;

class SiteTagRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(SiteTag $model)
    {
        $this->model = $model;
    }

}

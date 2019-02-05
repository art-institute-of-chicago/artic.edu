<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\SiteTag;

class SiteTagRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(SiteTag $model)
    {
        $this->model = $model;
    }

}

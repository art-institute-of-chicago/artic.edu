<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use App\Models\Sponsor;

class SponsorRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Sponsor $model)
    {
        $this->model = $model;
    }

}

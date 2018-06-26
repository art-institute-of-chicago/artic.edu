<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Sponsor;

class SponsorRepository extends ModuleRepository
{

    public function __construct(Sponsor $model)
    {
        $this->model = $model;
    }

}

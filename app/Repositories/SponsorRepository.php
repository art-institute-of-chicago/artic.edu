<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Sponsor;

class SponsorRepository extends ModuleRepository
{
    use HandleBlocks;

    public function __construct(Sponsor $model)
    {
        $this->model = $model;
    }

}

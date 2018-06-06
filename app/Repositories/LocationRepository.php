<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\Location;

class LocationRepository extends ModuleRepository
{
    public function __construct(Location $model)
    {
        $this->model = $model;
    }
}

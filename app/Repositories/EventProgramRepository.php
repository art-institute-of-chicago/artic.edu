<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use App\Models\EventProgram;

class EventProgramRepository extends ModuleRepository
{

    public function __construct(EventProgram $model)
    {
        $this->model = $model;
    }
}

<?php

namespace App\Repositories;

use App\Models\EventProgram;

class EventProgramRepository extends ModuleRepository
{
    public function __construct(EventProgram $model)
    {
        $this->model = $model;
    }
}

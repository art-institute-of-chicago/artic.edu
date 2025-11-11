<?php

namespace App\Repositories;

use App\Models\DigitalExplorerLight;

class DigitalExplorerLightRepository extends ModuleRepository
{
    public function __construct(DigitalExplorerLight $model)
    {
        $this->model = $model;
    }
}

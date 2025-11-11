<?php

namespace App\Repositories;

use App\Models\DigitalExplorerModel;

class DigitalExplorerModelRepository extends ModuleRepository
{
    public function __construct(DigitalExplorerModel $model)
    {
        $this->model = $model;
    }
}

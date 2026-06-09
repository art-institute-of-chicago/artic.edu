<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\DigitalExplorerTitleMedia;

class DigitalExplorerTitleMediaRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(DigitalExplorerTitleMedia $model)
    {
        $this->model = $model;
    }
}

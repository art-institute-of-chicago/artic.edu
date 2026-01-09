<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\DigitalExplorerAnnotation;

class DigitalExplorerAnnotationRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleMedias;

    public function __construct(DigitalExplorerAnnotation $model)
    {
        $this->model = $model;
    }
}

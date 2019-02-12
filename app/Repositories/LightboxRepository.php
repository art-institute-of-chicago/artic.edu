<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Lightbox;

class LightboxRepository extends ModuleRepository
{
    use HandleMedias;

    public function __construct(Lightbox $model)
    {
        $this->model = $model;
    }
}

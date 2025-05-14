<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\IlluminatedLink;

class IlluminatedLinkRepository extends ModuleRepository
{
    use HandleMedias;
    use HandleRevisions;

    public function __construct(IlluminatedLink $model)
    {
        $this->model = $model;
    }
}

<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\VanityRedirect;

class VanityRedirectRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(VanityRedirect $model)
    {
        $this->model = $model;
    }
}

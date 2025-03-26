<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\PublicationResource;

class PublicationResourceRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(PublicationResource $model)
    {
        $this->model = $model;
    }
}

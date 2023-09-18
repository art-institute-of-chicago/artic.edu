<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\SocialLink;

class SocialLinkRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(SocialLink $model)
    {
        $this->model = $model;
    }
}

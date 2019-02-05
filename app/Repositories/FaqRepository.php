<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\Faq;

class FaqRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }
}

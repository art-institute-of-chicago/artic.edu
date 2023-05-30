<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleTranslations;
use App\Models\MenuItem;

class MenuItemRepository extends ModuleRepository
{
    use HandleTranslations;

    public function __construct(MenuItem $model)
    {
        $this->model = $model;
    }
}

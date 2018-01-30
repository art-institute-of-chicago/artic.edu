<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\ShopItem;

class ShopItemRepository extends ModuleRepository
{

    public function __construct(ShopItem $model)
    {
        $this->model = $model;
    }

}

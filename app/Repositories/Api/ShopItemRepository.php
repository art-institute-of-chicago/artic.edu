<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Api\ShopItem;

class ShopItemRepository extends ModuleRepository
{

    public function __construct(ShopItem $model)
    {
        $this->model = $model;
    }

}

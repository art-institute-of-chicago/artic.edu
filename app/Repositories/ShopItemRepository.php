<?php

namespace App\Repositories;

use App\Models\ShopItem;

class ShopItemRepository extends ModuleRepository
{

    public function __construct(ShopItem $model)
    {
        $this->model = $model;
    }

}

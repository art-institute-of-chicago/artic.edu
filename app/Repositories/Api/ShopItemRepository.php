<?php

namespace App\Repositories\Api;

use App\Models\Api\ShopItem;

class ShopItemRepository extends BaseApiRepository
{
    public function __construct(ShopItem $model)
    {
        $this->model = $model;
    }
}

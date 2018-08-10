<?php

namespace App\Repositories\Api;

use App\Models\Api\ShopItem;
use App\Repositories\Api\BaseApiRepository;

class ShopItemRepository extends BaseApiRepository
{

    public function __construct(ShopItem $model)
    {
        $this->model = $model;
    }

    public function filter($query, array $scopes = [])
    {
        return parent::filter($query->active(), $scopes);
    }
}

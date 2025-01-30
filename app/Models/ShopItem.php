<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;
use App\Models\Api\ShopItem as ApiShopItem;

class ShopItem extends AbstractModel
{
    use HasApiModel;

    protected $apiModel = ApiShopItem::class;

    protected $fillable = [
        'datahub_id',
        'title',
        'description',
    ];
}

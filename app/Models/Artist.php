<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Artist extends Model
{
    use HasSlug;

    protected $fillable = [
        'name',
        'biography',
        'datahub_id',
    ];

    public $slugAttributes = [
        'name',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];

    public function shopItems()
    {
        return $this->morphToMany(\App\Models\ShopItem::class, 'shop_itemizable', 'shop_itemized');
    }
}

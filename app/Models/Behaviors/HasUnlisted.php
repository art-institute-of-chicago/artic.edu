<?php

namespace App\Models\Behaviors;

use App\Models\Vendor\Block;
use A17\Twill\Models\Behaviors\HasBlocks as BaseHasBlocks;

trait HasUnlisted
{

    public function scopeListed($query)
    {
        return $query->whereIsUnlisted(false);
    }

    public function getIsListedAttribute()
    {
        return static::listed()->find($this->id) !== null;
    }

}

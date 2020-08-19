<?php

namespace App\Models\Behaviors;

use App\Models\Vendor\Block;
use A17\Twill\Models\Behaviors\HasBlocks as BaseHasBlocks;

trait HasUnlisted
{

    public function scopeNotUnlisted($query)
    {
        return $query->whereIsUnlisted(false);
    }

    public function getIsNotUnlistedAttribute()
    {
        return isset($this->is_unlisted) ? !$this->is_unlisted : true;
    }

}

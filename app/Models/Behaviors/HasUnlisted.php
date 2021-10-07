<?php

namespace App\Models\Behaviors;

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

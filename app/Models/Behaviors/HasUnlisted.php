<?php

namespace App\Models\Behaviors;

use Illuminate\Database\Eloquent\Builder;

trait HasUnlisted
{
    public function scopeNotUnlisted($query): Builder
    {
        return $query->whereIsUnlisted(false);
    }

    public function getIsNotUnlistedAttribute()
    {
        return isset($this->is_unlisted) ? !$this->is_unlisted : true;
    }
}

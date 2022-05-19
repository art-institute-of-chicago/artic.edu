<?php

namespace App\Casts;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateIntervalCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return;
        }

        return new \DateInterval($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value)) {
            return [$key => null];
        }

        $value = is_string($value) ? CarbonInterval::create($value) : $value;

        return [$key => CarbonInterval::getDateIntervalSpec($value)];
    }
}

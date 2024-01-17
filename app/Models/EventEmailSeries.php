<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventEmailSeries extends Pivot
{
    protected $casts = [
        'override_affiliate' => 'boolean',
        'override_member' => 'boolean',
        'override_luminary' => 'boolean',
        'override_nonmember' => 'boolean',
    ];

    public $attributes = [
        'override_affiliate' => false,
        'override_member' => false,
        'override_luminary' => false,
        'override_nonmember' => false,
    ];
}

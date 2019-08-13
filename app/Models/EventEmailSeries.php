<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventEmailSeries extends Pivot
{
    protected $casts = [
        'override_affiliate' => 'boolean',
        'override_member' => 'boolean',
        'override_sustaining_fellow' => 'boolean',
        'override_nonmember' => 'boolean',
    ];
}

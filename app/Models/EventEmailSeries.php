<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventEmailSeries extends Pivot
{
    protected $casts = [
        'send_affiliate' => 'boolean',
        'send_member' => 'boolean',
        'send_sustaining_fellow' => 'boolean',
        'send_nonmember' => 'boolean',
    ];
}

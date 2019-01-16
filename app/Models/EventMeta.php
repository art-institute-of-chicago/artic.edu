<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMeta extends AbstractModel
{
    protected $fillable = [
        'date',
        'date_end',
        'event_id'
    ];

    protected $dates = ['date', 'date_end'];
}

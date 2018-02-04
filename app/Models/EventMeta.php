<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventMeta extends Model
{
    protected $fillable = [
        'date',
        'event_id'
    ];

    protected $dates = ['date'];
}

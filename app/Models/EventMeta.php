<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'date_end',
        'event_id'
    ];

    protected $dates = [
        'date',
        'date_end',
    ];
}

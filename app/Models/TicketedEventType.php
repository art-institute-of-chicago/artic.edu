<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;

class TicketedEventType extends AbstractModel
{
    use HasApiModel;

    protected $apiModel = 'App\Models\Api\TicketedEventType';

    protected $fillable = [
        'datahub_id',
        'title',
    ];
}

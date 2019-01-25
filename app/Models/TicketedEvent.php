<?php

namespace App\Models;


use App\Models\Behaviors\HasApiModel;

class TicketedEvent extends AbstractModel
{

    use HasApiModel;

    protected $apiModel = 'App\Models\Api\TicketedEvent';

    protected $fillable = [
        'datahub_id',
        'title',
    ];

}

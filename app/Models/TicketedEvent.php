<?php

namespace App\Models;

use A17\Twill\Models\Model;

use App\Models\Behaviors\HasApiModel;

class TicketedEvent extends Model
{

    use HasApiModel;

    protected $apiModel = 'App\Models\Api\TicketedEvent';

    protected $fillable = [
        'datahub_id',
        'title',
    ];

}

<?php

namespace App\Models;

use A17\Twill\Models\Model;

use App\Models\Behaviors\HasApiModel;

class TicketedEventType extends Model
{

    use HasApiModel;

    protected $apiModel = 'App\Models\Api\TicketedEventType';

    protected $fillable = [
        'datahub_id',
        'title',
    ];

}

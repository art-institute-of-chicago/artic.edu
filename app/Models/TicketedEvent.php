<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;

class TicketedEvent extends Model
{

    use HasApiModel;

    protected $apiModel = 'App\Models\Api\TicketedEvent';

    protected $fillable = [
        'datahub_id',
        'title',
    ];

    public function getTitleInBrowserAttribute()
    {
        return $this->title .' (' .$this->datahub_id .')';
    }

}

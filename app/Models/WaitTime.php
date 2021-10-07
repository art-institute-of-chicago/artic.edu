<?php

namespace App\Models;

use App\Models\Behaviors\HasApiModel;

class WaitTime extends AbstractModel
{
    use HasApiModel;

    protected $apiModel = 'App\Models\Api\WaitTime';

    protected $fillable = [
        'published',
        'duration',
        'units',
        'display',
    ];

    public $slugAttributes = [
        'title',
    ];
}

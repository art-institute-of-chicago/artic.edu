<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;

class Location extends Model
{

    protected $fillable = [
        'published',
        'name',
        'street',
        'address',
        'city',
        'state',
        'zip',
        'position',
        'page_id'
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [];
}

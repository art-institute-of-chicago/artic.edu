<?php
namespace App\Models;

use A17\CmsToolkit\Models\Model;

class Segment extends Model
{
    protected $fillable = [
        'name',
    ];

    public $slugAttributes = [
        'name',
    ];

}

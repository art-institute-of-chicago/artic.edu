<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class VanityRedirect extends Model
{
    use HasRevisions;

    protected $fillable = [
        'path',
        'destination',
        'published',
    ];

    public $checkboxes = [
        'published'
    ];
}

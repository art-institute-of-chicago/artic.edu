<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Model;

class Author extends Model
{
    use HasSlug, HasMedias, HasRevisions;

    protected $fillable = [
        'published',
        'title',
        'description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];
}

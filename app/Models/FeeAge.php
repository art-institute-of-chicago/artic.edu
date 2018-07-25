<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasTranslation;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class FeeAge extends Model implements Sortable
{
    use HasPosition, HasTranslation;

    protected $fillable = [
        'position',
    ];

    public $translatedAttributes = ['title'];
}

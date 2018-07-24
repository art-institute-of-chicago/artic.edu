<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class LocationTranslation extends Model
{
    protected $fillable = [
        'name',
        'active',
        'locale',
    ];
}

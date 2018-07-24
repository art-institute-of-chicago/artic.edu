<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class DiningHourTranslation extends Model
{
    protected $fillable = [
        'name',
        'hours',
        'active',
        'locale',
    ];
}

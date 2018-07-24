<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class FeeAgeTranslation extends Model
{
    protected $fillable = [
        'title',
        'active',
        'locale',
    ];
}

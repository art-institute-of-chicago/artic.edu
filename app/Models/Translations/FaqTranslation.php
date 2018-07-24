<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class FaqTranslation extends Model
{
    protected $fillable = [
        'title',
        'active',
        'locale',
    ];
}

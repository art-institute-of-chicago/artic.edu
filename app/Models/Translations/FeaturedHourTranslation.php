<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class FeaturedHourTranslation extends Model
{
    protected $fillable = [
        'title',
        'copy',
        'active',
        'locale',
    ];

}

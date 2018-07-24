<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class FeeCategoryTranslation extends Model
{
    protected $fillable = [
        'title',
        'tooltip',
        'active',
        'locale',
    ];
}

<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class GenericPageTranslation extends Model
{
    protected $fillable = [
        // 'title',
        // 'subtitle',
        'active',
        'locale',
    ];
}

<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;

class FamilyTranslation extends Model
{
    protected $fillable = [
        'title',
        'text',
        'link_label',
        'active',
        'locale',
    ];
}

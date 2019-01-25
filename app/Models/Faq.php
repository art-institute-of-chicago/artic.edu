<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;

class Faq extends AbstractModel
{
    use HasTranslation;

    protected $fillable = [
        'published',
        'position',
        'link',
        'page_id',
    ];

    public $translatedAttributes = [
        'title',
        'active'
    ];

    public $checkboxes = ['published', 'active'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}

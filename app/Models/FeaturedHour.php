<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;

class FeaturedHour extends AbstractModel
{
    use HasTranslation;

    protected $fillable = [
        'published',
        'position',
        'external_link',
        'page_id',
    ];

    public $translatedAttributes = [
        'title',
        'copy',
    ];

    /**
     * Those fields get auto set to false if not submitted
     */
    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}

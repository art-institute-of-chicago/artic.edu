<?php

namespace App\Models;

class Faq extends AbstractModel
{
    protected $fillable = [
        'published',
        'position',
        'link',
        'page_id',
        'title',
        'active'
    ];

    public $checkboxes = ['published', 'active'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}

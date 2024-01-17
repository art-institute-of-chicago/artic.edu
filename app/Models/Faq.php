<?php

namespace App\Models;

class Faq extends AbstractModel
{
    protected $fillable = [
        'published',
        'position',
        'link',
        'page_id',
        'landing_page_id',
        'title',
        'question',
        'answer',
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }
}

<?php

namespace App\Models;

class FeaturedHour extends AbstractModel
{
    protected $fillable = [
        'published',
        'position',
        'external_link',
        'page_id',
        'landing_page_id',
        'title',
        'copy',
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

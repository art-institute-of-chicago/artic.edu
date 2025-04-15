<?php

namespace App\Models;

class PublicationResource extends AbstractModel
{
    protected $fillable = [
        'published',
        'position',
        'resource_title',
        'resource_target',
        'resource_description',
        'resource_link_label',
        'resource_link_url',
        'landing_page_id'
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }
}

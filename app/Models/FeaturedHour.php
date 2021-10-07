<?php

namespace App\Models;

class FeaturedHour extends AbstractModel
{
    protected $fillable = [
        'published',
        'position',
        'external_link',
        'page_id',
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

<?php

namespace App\Models;


use A17\CmsToolkit\Models\Model;

class FeaturedHour extends Model 
{
    

    protected $fillable = [
        'published',
        'position',
        'title',
        'external_link',
        'copy',
        'page_id',
    ];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}

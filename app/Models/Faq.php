<?php

namespace App\Models;


use A17\CmsToolkit\Models\Model;

class Faq extends Model 
{
    

    protected $fillable = [
        'published',
        'position',
        'title',
        'link',
        'page_id'
    ];

    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }
}

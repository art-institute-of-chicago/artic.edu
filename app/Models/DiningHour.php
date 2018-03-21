<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;

class DiningHour extends Model 
{
    use HasMedias;

    protected $fillable = [
        'published',
        'position',
        'name',
        'hours',
        'page_id',
    ];
    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    // fill this in if you use the HasMedias traits
    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 4,
                ],
            ]
        ],
    ];
}

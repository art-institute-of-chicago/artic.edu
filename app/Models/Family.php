<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use A17\CmsToolkit\Models\Model;

class Family extends Model 
{
    use HasMedias, HasMediasEloquent;

     protected $fillable = [
        'published',
        'position',
        'title',
        'text',
        'link_label',
        'external_link',
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
                    'name' => 'cover',
                    'ratio' => 3 / 4,
                ],
            ]
        ],
    ];
}

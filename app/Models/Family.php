<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;

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

    public $mediasParams = [
        'family_cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ]
        ],
    ];
}

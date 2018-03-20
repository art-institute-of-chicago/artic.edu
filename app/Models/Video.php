<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Model;

class Video extends Model 
{
    use HasSlug, HasMedias, HasFiles;

    protected $fillable = [
        'published',
        'date',
        'title',
        'heading',
        'video_url'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    // fill this in if you use the HasMedias traits
    // public $mediasParams = [
    //     'cover' => [
    //         'default' => [
    //             [
    //                 'name' => 'landscape',
    //                 'ratio' => 16 / 9,
    //             ],
    //             [
    //                 'name' => 'portrait',
    //                 'ratio' => 3 / 4,
    //             ],
    //         ],
    //         'mobile' => [
    //             [
    //                 'name' => 'mobile',
    //                 'ratio' => 1,
    //             ],
    //         ],
    //     ],
    // ];
}

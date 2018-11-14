<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;

class Lightbox extends Model 
{
    use HasMedias;

    protected $fillable = [
        // 'published',
        // 'position',
        // 'public',
        // 'featured',
        // 'publish_start_date',
        // 'publish_end_date',
    ];

    // public $translatedAttributes = [
    //     'title',
    //     'description',
    //     'active',
    // ];

    // public $slugAttributes = [
    //     'title',
    // ];

    // public $checkboxes = ['published', 'active'];

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

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class ExperienceImage extends Model implements Sortable
{
    use HasBlocks, HasMedias, HasFiles, HasRevisions, HasPosition;

    protected $fillable = [
        'published',
        'title',
        'position',
        'youtube_url',
        'alt_text',
        'inline_credits',
        'credits_input',
        'object_id',
        'artist',
        'credit_title',
        'credit_date',
        'medium',
        'dimensions',
        'credit_line',
        'main_reference_number',
        'copyright_notice',
        'imagable_type',
        'imagable_id',
        'imagable_repeater_name',
        // 'description',
        // 'public',
        // 'featured',
        // 'publish_start_date',
        // 'publish_end_date',
    ];

    // uncomment and modify this as needed if you use the HasTranslation trait
    // public $translatedAttributes = [
    //     'title',
    //     'description',
    //     'active',
    // ];

    // uncomment and modify this as needed if you use the HasSlug trait
    // public $slugAttributes = [
    //     'title',
    // ];

    // add checkbox fields names here (published toggle is itself a checkbox)
    public $checkboxes = [
        'published',
    ];

    // uncomment and modify this as needed if you use the HasMedias trait
    // public $mediasParams = [
    //     'experience_image' => [
    //         'default' => [
    //             [
    //                 'name' => 'Uncropped',
    //                 'ratio' => null,
    //             ],
    //         ],
    //     ],
    // ];
}

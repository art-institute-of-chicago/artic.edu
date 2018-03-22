<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
// use A17\CmsToolkit\Models\Behaviors\HasTranslation;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;

class PressRelease extends Model
{
    use HasBlocks,  HasSlug, HasMedias, HasFiles, HasRevisions;
    // HasTranslation

    protected $fillable = [
        'short_description',
        'title',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
    ];

    // public $translatedAttributes = [
    //     'title',
    //     'description',
    //     'active',
    // ];

    public $slugAttributes = [
        'title'
    ];

    public $checkboxes = ['published', 'active', 'public'];
    public $dates = ['publish_start_date', 'publish_end_date'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    // protected $presenter = 'App\Presenters\HoursPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\PressReleasePresenter';

}

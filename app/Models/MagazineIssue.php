<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;

use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class MagazineIssue extends AbstractModel
{
    use HasSlug, HasRevisions, HasBlocks, HasMedias, HasMediasEloquent;

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

    protected $fillable = [
        'title',
        'list_description',
        'publish_start_date',
        'published',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];
}

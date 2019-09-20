<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class Family extends AbstractModel
{
    use HasMedias, HasMediasEloquent, HasTranslation;

    protected $fillable = [
        'published',
        'position',
        'external_link',
        'associated_generic_page_link',
        'page_id',
    ];

    public $translatedAttributes = [
        'title',
        'text',
        'link_label',
    ];

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
            ],
        ],
    ];
}

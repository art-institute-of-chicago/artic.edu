<?php

namespace App\Models;

use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class Family extends AbstractModel
{
    use HasMedias;
    use HasMediasEloquent;

    protected $fillable = [
        'published',
        'position',
        'external_link',
        'associated_generic_page_link',
        'page_id',
        'landing_page_id',
        'title',
        'text',
        'link_label',
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
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

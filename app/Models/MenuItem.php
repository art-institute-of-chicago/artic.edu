<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Model;

class MenuItem extends Model
{
    use HasPosition;

    protected $fillable = [
        'published',
        'position',
        'label',
        'link',
        'page_id',
        'landing_page_id'
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function landingPage()
    {
        return $this->belongsTo('App\Models\LandingPage');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'label',
                'doc' => 'Menu Label',
                'type' => 'string',
                'value' => function () {
                    return $this->label;
                },
            ],
            [
                'name' => 'link',
                'doc' => 'Menu Link',
                'type' => 'string',
                'value' => function () {
                    return $this->link;
                },
            ]
        ];
    }
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasTranslation;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class DiningHour extends AbstractModel
{
    use HasMedias, HasMediasEloquent, HasTranslation;

    protected $fillable = [
        'published',
        'position',
        'page_id',
    ];

    public $translatedAttributes = [
        'name',
        'hours',
    ];

    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    // fill this in if you use the HasMedias traits
    public $mediasParams = [
        'dining_cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 3 / 4,
                ],
            ],
        ],
    ];

    public function getAccessibleHoursAttribute()
    {
        return str_replace('–', '<span aria-hidden="true">–</span><span class="sr-only"> to </span>', $this->hours);
    }
}

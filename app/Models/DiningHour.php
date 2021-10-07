<?php

namespace App\Models;

use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class DiningHour extends AbstractModel
{
    use HasMedias, HasMediasEloquent;

    protected $fillable = [
        'published',
        'position',
        'page_id',
        'name',
        'hours',
    ];

    public $checkboxes = ['published'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    /**
     * Required by the HasMedias trait
     */
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

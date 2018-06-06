<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;

class DiningHour extends Model
{
    use HasMedias, HasMediasEloquent;

    protected $fillable = [
        'published',
        'position',
        'name',
        'hours',
        'page_id',
    ];
    // those fields get auto set to false if not submited
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
}

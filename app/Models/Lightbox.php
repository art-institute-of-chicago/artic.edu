<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use A17\Twill\Models\Model;

class Lightbox extends Model
{
    use HasMedias, HasMediasEloquent;

    protected $fillable = [
        'published',
        'title',
        'header',
        'body',
        'lightbox_start_date',
        'lightbox_end_date',
        'lightbox_button_text',
        'terms_text',
        'action_url',
        'form_id',
        'form_token',
        'form_tlc_source',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 3 / 4,
                ],
            ],
        ],
    ];
}

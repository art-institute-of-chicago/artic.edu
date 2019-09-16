<?php

namespace App\Models;

use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class Lightbox extends AbstractModel
{
    use HasMedias, HasMediasEloquent;

    protected $fillable = [
        'published',
        'title',
        'header',
        'subheader',
        'cover_caption',
        'body',
        'lightbox_start_date',
        'lightbox_end_date',
        'expiry_period',
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

    public $casts = [
        'lightbox_start_date' => 'datetime',
        'lightbox_end_date' => 'datetime',
    ];

    protected $presenter = 'App\Presenters\Admin\LightboxPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\LightboxPresenter';

}

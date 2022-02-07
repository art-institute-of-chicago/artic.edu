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
        'hide_fields',
        'geotarget',
        'lightbox_start_date',
        'lightbox_end_date',
        'expiry_period',
        'lightbox_button_text',
        'variation',
        'terms_text',
        'action_url',
        'form_id',
        'form_token',
        'form_tlc_source',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
        'hide_fields',
    ];

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

    const GEOTARGET_ALL = 1;
    const GEOTARGET_LOCAL = 2;
    const GEOTARGET_NOT_LOCAL = 3;

    const VARIATION_DEFAULT = 1;
    const VARIATION_TICKETING = 2;
    const VARIATION_EMAIL = 3;
    const VARIATION_NEWSLETTER = 4;

    public function getVariationClassAttribute()
    {
        switch ($this->variation) {
            case self::VARIATION_TICKETING:
                return 'ticketing';

                break;
            case self::VARIATION_EMAIL:
                return 'email';

                break;
            case self::VARIATION_NEWSLETTER:
                return 'newsletter';

                break;
            default:
                return 'default';

                break;
        }
    }

    public function getActionUrlAttribute($value)
    {
        if ($this->variation === self::VARIATION_NEWSLETTER) {
            return '/subscribe';
        }

        return $value;
    }
}

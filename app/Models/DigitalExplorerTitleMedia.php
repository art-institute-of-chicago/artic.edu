<?php

namespace App\Models;

use A17\Twill\Models\Model as AbstractModel;
use A17\Twill\Models\Behaviors\HasPosition;
use App\Models\Behaviors\HasMedias;

class DigitalExplorerTitleMedia extends AbstractModel
{
    use HasPosition;
    use HasMedias;

    public $mediasParams = [
        'explorer_title_media' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 0,
                ],
            ],
        ],
    ];

    protected $table = 'explorer_title_media';

    protected $fillable = [
        'published',
        'position',
        'mediable_id',
        'mediable_type',
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => true,
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}

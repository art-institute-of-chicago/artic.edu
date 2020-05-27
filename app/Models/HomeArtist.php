<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class HomeArtist extends AbstractModel implements Sortable
{
    use HasMedias, HasPosition, HasApiRelations, HasMediasEloquent, HasRelated;

    protected $fillable = [
        'published',
        'title',
        'position',
        'page_id',
    ];

    public $checkboxes = [
        'published'
    ];

    public $mediasParams = [
        'artist_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 3 / 4,
                ],
            ],
        ],
    ];

    public function artists()
    {
        return $this->apiElements()->where('relation', 'artists');
    }
}

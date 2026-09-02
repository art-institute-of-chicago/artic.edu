<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasApiRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdCampaign extends AbstractModel implements Sortable
{
    use HasApiRelations;
    use HasFactory;
    use HasMedias;
    use HasPosition;
    use HasRevisions;

    protected $fillable = [
        'published',
        'position',
        'title',
        'start_date',
        'end_date',
        'header',
        'description',
        'destination_url',
        'destination_label',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 'default',
                ],
            ],
        ],
    ];

    public function artists()
    {
        return $this->apiElements()->where('relation', 'artists');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }
}

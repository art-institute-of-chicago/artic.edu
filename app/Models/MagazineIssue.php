<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;

use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class MagazineIssue extends AbstractModel
{
    use HasSlug, HasRevisions, HasBlocks, HasMedias, HasMediasEloquent, HasRelated;

    protected $presenter = 'App\Presenters\Admin\MagazineIssuePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\MagazineIssuePresenter';

    protected $fillable = [
        'title',
        'list_description',
        'hero_caption',
        'hero_text',
        'welcome_note_display',
        'welcome_note_author_override',
        'publish_start_date',
        'published',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function magazineItems()
    {
        return $this->hasMany(MagazineItem::class)->orderBy('position');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('publish_start_date', 'desc');
    }
}

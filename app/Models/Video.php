<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Model;

class Video extends Model
{
    use HasSlug, HasMedias, HasFiles;

    protected $fillable = [
        'published',
        'date',
        'title',
        'heading',
        'video_url'
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ]
        ],
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('videos'), '/', $this->id, '-']);
    }
}

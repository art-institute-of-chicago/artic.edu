<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;

class Video extends Model
{
    use HasSlug, HasMedias, HasFiles, HasMediasEloquent;

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

    public function getEmbedAttribute()
    {
        return \EmbedConverter::convertUrl($this->video_url);
    }

    public function getUrlAttribute()
    {
        return $this->video_url;
    }

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

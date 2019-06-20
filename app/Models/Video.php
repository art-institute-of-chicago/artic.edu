<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasMediasEloquent;

class Video extends AbstractModel
{
    use HasSlug, HasRevisions, HasMedias, HasFiles, HasMediasEloquent;

    protected $presenter = 'App\Presenters\Admin\VideoPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\VideoPresenter';

    protected $fillable = [
        'published',
        'date',
        'title',
        'heading',
        'video_url',
    ];

    protected $dates = ['date'];
    protected $appends = ['embed'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
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
        // Workaround for the CMS, should be moved away from the model
        return join([route('videos'), '/', $this->id, '-']);
    }
}

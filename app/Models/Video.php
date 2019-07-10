<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class Video extends AbstractModel
{
    use HasSlug, HasRevisions, HasMedias, HasFiles, HasMediasEloquent, HasRelated, Transformable;

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

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'publish_start_date',
                "doc" => "Publish Start Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_start_date; }
            ],
            [
                "name" => 'publish_end_date',
                "doc" => "Publish End Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_end_date; }
            ],
            [
                "name" => 'date',
                "doc" => "Date",
                "type" => "date",
                "value" => function () {return $this->date;},
            ],
            [
                "name" => 'video_url',
                "doc" => "Video URL",
                "type" => "text",
                "value" => function () {return $this->video_url;},
            ],
            [
                "name" => "slug",
                "doc" => "slug",
                "type" => "string",
                "value" => function () {return $this->slug;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return url(route('articles.show', $this));},
            ],
            [
                "name" => "heading",
                "doc" => "heading",
                "type" => "string",
                "value" => function () {return $this->heading;},
            ],
            [
                "name" => 'related',
                "doc" => "Related Content",
                "type" => "array",
                "value" => function () { return $this->transformRelated(); },
            ],
        ];
    }
}

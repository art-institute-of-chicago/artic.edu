<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class Issue extends AbstractModel implements Sortable
{
    use HasSlug, HasMedias, HasMediasEloquent, HasRevisions, HasPosition;

    protected $presenter = 'App\Presenters\Admin\IssuePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\IssuePresenter';

    protected $fillable = [
        'title',
        'title_display',
        'issue_number',
        'date',
        'header_text',
        'list_description',
        'license_text',
        'publish_start_date',
        // https://github.com/area17/twill/issues/227
        'published',
        'position',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $dates = [
        'date',
        'publish_start_date',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'license' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public function articles()
    {
        return $this->hasMany('App\Models\IssueArticle', 'issue_id');
    }

    public function getEditorsNote()
    {
        return $this->articles()->where('type', 'editors-note')->first();
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'issue_slug';
    }

    public function getIssueSlugAttribute()
    {
        return join([$this->issue_number, $this->getSlug()], '/');
    }
}

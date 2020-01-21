<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;

class IssueArticle extends Model implements Sortable
{
    use HasSlug, HasMedias, HasRevisions, HasPosition;

    protected $presenter = 'App\Presenters\Admin\IssueArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\IssueArticlePresenter';

    protected $fillable = [
        'published',
        'title',
        'title_display',
        'short_title_display',
        'description',
        'date',
        'type',
        'abstract',
        'author_display',
        'review_status',
        'license_text',
        'publish_start_date',
        'issue_id',
        'position',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
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

    public function issue()
    {
        return $this->belongsTo('App\Models\Issue');
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'issue_slug';
    }

    public function getIssueSlugAttribute()
    {
        return join([$this->issue->issue_number ?? '', $this->issue->getSlug(), $this->id, $this->getSlug()], '/');
    }
}

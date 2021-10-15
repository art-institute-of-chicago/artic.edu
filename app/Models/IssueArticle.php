<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

use App\Models\Behaviors\HasAuthors;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasBlocks;

class IssueArticle extends AbstractModel implements Sortable
{
    use HasSlug, HasRevisions, HasPosition, HasMedias, HasMediasEloquent, HasBlocks, HasAuthors;

    protected $presenter = 'App\Presenters\Admin\IssueArticlePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\IssueArticlePresenter';

    protected $fillable = [
        'published',
        'title',
        'title_display',
        'short_title_display',
        'description',
        'list_description',
        'date',
        'type',
        'abstract',
        'author_display',
        'review_status',
        'license_text',
        'publish_start_date',
        'issue_id',
        'position',
        'pdf_download_path',
        'cite_as',
        'type_display',
        'meta_title',
        'meta_description',
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
            'special' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
                ],
            ],
        ],
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
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

    public function scopePublished($query)
    {
        parent::scopePublished($query);

        // ...and the parent issue has to be published as well
        return $query->whereHas('issue', function ($subquery) {
            $subquery->published();
        });
    }

    public function getPublishedAttribute()
    {
        return ($this->issue->isPublished ?? false) && $this->isPublished;
    }

    public function issue()
    {
        return $this->belongsTo('App\Models\Issue');
    }

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'issue_slug';
    }

    public function getIssueSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlAttribute()
    {
        return route('issue-articles.show', ['id' => $this->id, 'slug' => $this->getSlug()], false);
    }
}

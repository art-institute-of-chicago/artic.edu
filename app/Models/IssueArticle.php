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

use Illuminate\Database\Eloquent\Factories\HasFactory;

class IssueArticle extends AbstractModel implements Sortable
{
    use HasSlug, HasRevisions, HasPosition, HasMedias, HasMediasEloquent, HasBlocks, HasAuthors, HasFactory, Transformable;

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

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
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
        return join('/', [$this->id, $this->getSlug()]);
    }

    public function getUrlAttribute()
    {
        return route('issue-articles.show', ['id' => $this->id, 'slug' => $this->getSlug()], false);
    }

    /**
     * PUB-146: Affects what _m-listing is used for Writings landing
     */
    public function getTypeAttribute()
    {
        return 'journal-article';
    }

    /**
     * PUB-146: Affects the tag on Writings landing
     */
    public function getSubtypeAttribute()
    {
        return $this->type_display ?? 'Journal Article';
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'publish_start_date',
                'doc' => 'Publish Start Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_start_date;
                }
            ],
            [
                'name' => 'date',
                'doc' => 'Date',
                'type' => 'date',
                'value' => function () {
                    return $this->date;
                },
            ],
            [
                'name' => 'copy',
                'doc' => 'Copy',
                'type' => 'text',
                'value' => function () {
                    return $this->blocks;
                },
            ],
            [
                'name' => 'slug',
                'doc' => 'Slug',
                'type' => 'string',
                'value' => function () {
                    return $this->slug;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'Web URL',
                'type' => 'string',
                'value' => function () {
                    return url(route('issues.show', $this));
                },
            ],
            [
                'name' => 'description',
                'doc' => 'Description',
                'type' => 'string',
                'value' => function () {
                    return $this->description;
                },
            ],
            [
                'name' => 'list_description',
                'doc' => 'List description',
                'type' => 'string',
                'value' => function () {
                    return $this->list_description;
                },
            ],
            [
                'name' => 'issue_id',
                'doc' => 'Issue ID',
                'type' => 'integer',
                'value' => function () {
                    return $this->issue_id;
                },
            ],
            [
                'name' => 'license_text',
                'doc' => 'License text',
                'type' => 'string',
                'value' => function () {
                    return $this->license_text;
                },
            ],
            [
                'name' => 'abstract',
                'doc' => 'Abstract',
                'type' => 'string',
                'value' => function () {
                    return $this->abstract;
                },
            ],
            [
                'name' => 'author_display',
                'doc' => 'Author display',
                'type' => 'string',
                'value' => function () {
                    return $this->author_display;
                },
            ],
            [
                'name' => 'review_status',
                'doc' => 'Review status',
                'type' => 'string',
                'value' => function () {
                    return $this->review_status;
                },
            ],
            [
                'name' => 'cite_as',
                'doc' => 'Cite as',
                'type' => 'string',
                'value' => function () {
                    return $this->cite_as;
                },
            ],
            [
                'name' => 'type_display',
                'doc' => 'Type display',
                'type' => 'string',
                'value' => function () {
                    return $this->type_display;
                },
            ],
        ];
    }
}

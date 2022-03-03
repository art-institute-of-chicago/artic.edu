<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;

use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Issue extends AbstractModel implements Sortable
{
    use HasSlug, HasMedias, HasMediasEloquent, HasRevisions, HasPosition, HasRelated, HasFactory;

    protected $presenter = 'App\Presenters\Admin\IssuePresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\IssuePresenter';

    protected $fillable = [
        'title',
        'title_display',
        'issue_number',
        'date',
        'header_text',
        'list_description',
        'hero_caption',
        'license_text',
        'publish_start_date',
        // https://github.com/area17/twill/issues/227
        'published',
        'position',
        'cite_as',
        'welcome_note_display',
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

    public function articles()
    {
        return $this->hasMany('App\Models\IssueArticle', 'issue_id');
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
        return join('/', [$this->issue_number, $this->getSlug()]);
    }

    /**
     * PUB-146: Affects what _m-listing is used for Writings landing
     */
    public function getTypeAttribute()
    {
        return 'journal-issue';
    }

    /**
     * PUB-146: Affects the tag on Writings landing
     */
    public function getSubtypeAttribute()
    {
        return 'Issue ' . $this->issue_number;
    }
}

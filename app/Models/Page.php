<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Admission as Admission;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;

class Page extends AbstractModel
{
    use HasSlug;
    use HasRevisions;
    use HasMedias;
    use HasFiles;
    use HasMediasEloquent;
    use HasApiRelations;
    use Transformable;
    use HasRelated;

    protected $presenter = 'App\Presenters\Admin\PagePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdatePage::class,
    ];

    public static $types = [
        1 => 'Exhibitions and Events',
        2 => 'Art and Ideas', // WEB-2262: now The Collection
        4 => 'Articles',
        5 => 'Exhibition History',
        6 => 'Collection',
    ];

    protected $fillable = [
        'published',
        'position',
        'type',
        'title',

        // Exhibition
        'exhibition_intro',

        // Exhibition History
        'exhibition_history_sub_heading',
        'exhibition_history_intro_copy',
        'exhibition_history_popup_copy',

        // Art and Ideas
        'art_intro',

        // Printed catalogs
        'printed_publications_intro',

        'active',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $casts = [
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
        'exhibition_history_intro' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    /**
     * A list of file roles
     */
    public $filesParams = ['video'];

    public static $iconTypes = [
        0 => 'Face Coverings',
        1 => 'Physical Distancing',
        2 => 'Mobile Ticket',
        3 => 'Showing Symptoms',
        4 => 'No Checkroom',
        5 => 'No Dining',
        6 => 'Caution',
        7 => 'Floor Icon',
        8 => 'Virtual Queue',
        9 => 'Proof of Vaccination',
        10 => 'Dining'
    ];

    public function scopeForType($query, $type): Builder
    {
        return $query->where('type', array_flip(self::$types)[$type]);
    }

    public function scopeIds($query, $ids = []): Builder
    {
        return $query->whereIn('id', $ids);
    }

    public function exhibitionsCurrent()
    {
        return $this->apiElements()->where('relation', 'exhibitionsCurrent');
    }

    public function exhibitionsUpcomingListing()
    {
        return $this->apiElements()->where('relation', 'exhibitionsUpcomingListing');
    }

    public function articlesCategories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'page_article_category')->withPivot('position')->orderBy('position');
    }

    public function artArticles()
    {
        return $this->belongsToMany('App\Models\Article', 'page_art_article')->withPivot('position')->orderBy('position');
    }

    public function artCategoryTerms()
    {
        return $this->apiElements()->where('relation', 'artCategoryTerms');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article')->withPivot('position')->orderBy('position');
    }

    public function digitalPublications()
    {
        return $this->belongsToMany('App\Models\DigitalPublication')->withPivot('position')->orderBy('position');
    }

    public function experiences()
    {
        return $this->belongsToMany('App\Models\Experience')->withPivot('position')->orderBy('experience_page.position');
    }

    public function printedPublications()
    {
        return $this->belongsToMany('App\Models\PrintedPublication')->withPivot('position')->orderBy('position');
    }

    public static function getIconTypes()
    {
        return collect(self::$iconTypes);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'published',
                'doc' => 'Published?',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],

            [
                'name' => 'type',
                'doc' => 'Type of Page',
                'type' => 'integer',
                'value' => function () {
                    return $this->type;
                },
            ],

            [
                'name' => 'exhibition_intro',
                'doc' => 'Exhibition Intro',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_intro;
                },
            ],

            [
                'name' => 'art_intro',
                'doc' => 'Art Intro',
                'type' => 'string',
                'value' => function () {
                    return $this->art_intro;
                },
            ],

            [
                'name' => 'slug',
                'doc' => 'slug',
                'type' => 'string',
                'value' => function () {
                    return $this->slug;
                },
            ],

            [
                'name' => 'exhibition_history_sub_heading',
                'doc' => 'exhibition_history_sub_heading',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_history_sub_heading;
                },
            ],

            [
                'name' => 'exhibition_history_intro_copy',
                'doc' => 'exhibition_history_intro_copy',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_history_intro_copy;
                },
            ],

            [
                'name' => 'exhibition_history_popup_copy',
                'doc' => 'exhibition_history_popup_copy',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_history_popup_copy;
                },
            ],

            [
                'name' => 'exhibition_intro',
                'doc' => 'exhibition_intro',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_intro;
                },
            ],

            [
                'name' => 'content',
                'doc' => 'content',
                'type' => 'string',
                'value' => function () {
                    return $this->blocks;
                },
            ],

        ];
    }
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Admission;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Slugs\LandingPageSlug;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\NodeTrait;

class LandingPage extends AbstractModel implements Sortable
{
    use HasFactory;
    use HasSlug;
    use HasRevisions;
    use HasPosition;
    use HasMedias;
    use HasFiles;
    use HasMediasEloquent;
    use HasApiRelations;
    use Transformable;
    use HasRelated;
    use HasBlocks;
    use NodeTrait;

    public const DEFAULT_TYPE = 'Custom';

    public const TYPES = [
        0 => 'RLC',
        1 => 'Home',
        // 2 => 'Exhibitions and Events',
        // 3 => 'Collection',
        4 => 'Visit',
        // 5 => 'Articles',
        // 6 => 'Exhibition History',
        // 7 => 'Art and Ideas',
        // 8 => 'Research and Resources',
        // 9 => 'Articles and Publications',
       10 => 'Editorial',
       11 => 'My Museum Tour',
       12 => 'Publications',
       99 => 'Custom',
    ];

    protected $presenter = 'App\Presenters\Admin\LandingPagePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateLandingPage::class,
    ];

    protected $fillable = [
        'published',
        'position',
        'type_id',
        'title',
        'intro',
        'meta_title',
        'meta_description',
        'search_tags',
        'header_variation',
        'header_cta_button_link',
        'header_cta_button_label',
        'header_cta_title',
        'hide_hours',
        'hour_intro',
        'hour_image_caption',
        'hour_header',
        'hour_subheader',
        'labels',
        'active',
    ];

    protected $appends = [
        'type',
    ];

    public $casts = [
        'labels' => AsCollection::class,
        'published' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
    ];

    public $slugAttributes = [
        'title',
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
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
        'visit_featured_hour' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'visit_accessibility' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'visit_map' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
        'visit_city_pass' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 9 / 5,
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
        'home_cta_module_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 25 / 4,
                ],
            ],
        ],
        'research_landing_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 40 / 27,
                ],
            ],
        ],
        'rlc_location' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'header_my_museum_tour_header_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 2267 / 742,
                ],
            ],
        ],
        'header_my_museum_tour_header_image_mobile' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'header_my_museum_tour_header_image_pdf' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1389 / 782,
                ],
            ],
        ],
        'tours_create_cta_module_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 25 / 4,
                ],
            ],
        ],
        'tours_tickets_cta_module_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 25 / 4,
                ],
            ],
        ],
    ];

    /**
     * A list of file roles
     */
    public $filesParams = ['video'];

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes): string => collect(self::TYPES)->get($attributes['type_id']),
        );
    }

    public function scopeIds($query, $ids = []): Builder
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeById($query, $id = null): Builder
    {
        if (empty($id)) {
            return $query;
        }

        return $query->join('landing_page_slugs', function ($join) use ($id) {
            $join->on('landing_page_slugs.landing_page_id', 'landing_pages.id')
                 ->where('landing_page_slugs.id', $id)
                 ->where('landing_page_slugs.active', true)
                 ->whereNull('landing_page_slugs.deleted_at');
        });
    }

    public function features()
    {
        return $this->belongsToMany('\App\Models\PageFeature', 'landing_page_page_feature')->withPivot('position')->orderBy('position');
    }

    public function primaryFeatures()
    {
        return $this->belongsToMany('App\Models\PageFeature', 'landing_page_primary_page_feature')->withPivot('position')->orderBy('position');
    }

    public function secondaryFeatures()
    {
        return $this->belongsToMany('App\Models\PageFeature', 'landing_page_secondary_page_feature')->withPivot('position')->orderBy('position');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'landingArtworks');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class)->orderBy('position');
    }

    public function artists()
    {
        return $this->hasMany(HomeArtist::class)->orderBy('position');
    }

    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('position');
    }

    public function dining_hours() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(DiningHour::class)->orderBy('position');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->orderBy('position');
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class)->orderBy('position');
    }

    public function families()
    {
        return $this->hasMany(Family::class)->orderBy('position');
    }

    public function featured_hours() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(FeaturedHour::class)->orderBy('position');
    }

    public function whatToExpects()
    {
        return $this->hasMany(WhatToExpect::class)->orderBy('position');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class)->orderBy('position');
    }

    public function articlesCategories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'landing_page_article_categories')->withPivot('position')->orderBy('position');
    }

    public function artArticles()
    {
        return $this->belongsToMany(\App\Models\Article::class, 'landing_page_art_articles')->withPivot('position')->orderBy('position');
    }
    public function artCategoryTerms()
    {
        return $this->apiElements()->where('relation', 'artCategoryTerms');
    }

    public function experiences()
    {
        return $this->belongsToMany(\App\Models\Experience::class, 'experience_page')->withPivot('position')->orderBy('experience_page.position');
    }

    public function researchResourcesStudyRooms()
    {
        return $this->belongsToMany(\App\Models\GenericPage::class, 'research_resource_study_room_pages')->withPivot('position')->orderBy('research_resource_study_room_pages.position', 'asc');
    }

    public function researchResourcesStudyRoomMore()
    {
        return $this->belongsToMany(\App\Models\GenericPage::class, 'research_resource_study_room_more_pages')->withPivot('position')->orderBy('research_resource_study_room_more_pages.position', 'asc');
    }

    public function genericPages()
    {
        return $this->belongsToMany(\App\Models\GenericPage::class, 'landing_page_generic_pages')->withPivot('position')->orderBy('landing_page_generic_pages.position', 'asc');
    }

    public function landingPageSlug()
    {
        return $this->hasOne(LandingPageSlug::class, 'slug');
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
                'name' => 'page_types',
                'doc' => 'Page Types',
                'type' => 'array',
                'value' => function () {
                    return self::TYPES;
                }
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
                'name' => 'home_intro',
                'doc' => 'Home Intro',
                'type' => 'string',
                'value' => function () {
                    return $this->home_intro;
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
                'name' => 'visit_intro',
                'doc' => 'visit_intro',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_intro;
                },
            ],

            [
                'name' => 'visit_hour_header',
                'doc' => 'visit_hour_header',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_hour_header;
                },
            ],

            [
                'name' => 'visit_hour_subheader',
                'doc' => 'visit_hour_subheader',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_hour_subheader;
                },
            ],

            [
                'name' => 'visit_city_pass_title',
                'doc' => 'visit_city_pass_title',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_city_pass_title;
                },
            ],

            [
                'name' => 'visit_city_pass_text',
                'doc' => 'visit_city_pass_text',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_city_pass_text;
                },
            ],

            [
                'name' => 'visit_admission_description',
                'doc' => 'visit_admission_description',
                'type' => 'string',
                'value' => function () {
                    return $this->visit_admission_description;
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

    public function getUrl($prefix = '')
    {
        return $prefix . '/' . $this->slug;
    }
}

<?php

namespace App\Models;

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
    use HasSlug, HasRevisions, HasMedias, HasFiles, HasMediasEloquent, HasApiRelations, Transformable, HasRelated;

    protected $presenter = 'App\Presenters\Admin\PagePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdatePage::class,
    ];

    public static $types = [
        0 => 'Home',
        1 => 'Exhibitions and Events',
        2 => 'Art and Ideas', // WEB-2262: now The Collection
        3 => 'Visit',
        4 => 'Articles',
        5 => 'Exhibition History',
        6 => 'Collection',
        7 => 'Research and Resources',
        8 => 'Articles and Publications',
    ];

    protected $fillable = [
        'published',
        'position',
        'type',
        'title',

        // Homepage
        'home_intro',
        'home_visit_button_text',
        'home_visit_button_url',
        'home_plan_your_visit_link_1_text',
        'home_plan_your_visit_link_1_url',
        'home_plan_your_visit_link_2_text',
        'home_plan_your_visit_link_2_url',
        'home_plan_your_visit_link_3_text',
        'home_plan_your_visit_link_3_url',

        'home_cta_module_action_url',
        'home_cta_module_image',
        'home_cta_module_header',
        'home_cta_module_body',
        'home_cta_module_button_text',
        'home_cta_module_variation',
        'home_cta_module_form_id',
        'home_cta_module_form_token',
        'home_cta_module_form_tlc_source',

        'home_video_title',
        'home_video_description',

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

        // Resources Landing page
        'resources_landing_title',
        'resources_landing_intro',

        // Visit page
        'visit_hide_hours',
        'visit_dining_link',
        'visit_transportation_link',
        'visit_parking_link',
        'visit_buy_tickets_link',
        'visit_become_member_link',
        'visit_faq_accessibility_link',
        'visit_faq_more_link',
        'visit_accessibility_link_url',
        'visit_cta_module_action_url',
        'visit_what_to_expect_more_link',
        'visit_capacity_btn_url_1',
        'visit_capacity_btn_url_2',
        'visit_intro',
        'visit_hour_header',
        'visit_hour_subheader',
        'visit_hour_intro',
        'visit_hour_image_caption',
        'visit_city_pass_title',
        'visit_city_pass_text',
        'visit_city_pass_button_label',
        'visit_city_pass_link',
        'visit_admission_description',
        'visit_buy_tickets_label',
        'visit_become_member_label',
        'visit_accessibility_text',
        'visit_accessibility_link_text',
        'visit_cta_module_header',
        'visit_cta_module_body',
        'visit_cta_module_button_text',
        'visit_what_to_expect_more_text',
        'visit_capacity_alt',
        'visit_capacity_heading',
        'visit_capacity_text',
        'visit_capacity_btn_text_1',
        'visit_capacity_btn_text_2',
        'active',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

    public $mediasParams = [
        'visit_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 21 / 9,
                ],
            ],
        ],
        'visit_mobile' => [
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
    ];

    public function scopeForType($query, $type)
    {
        return $query->where('type', array_flip(self::$types)[$type]);
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function homeExhibitions()
    {
        return $this->apiElements()->where('relation', 'homeExhibitions');
    }

    public function exhibitionsExhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitionsExhibitions');
    }

    public function exhibitionsCurrent()
    {
        return $this->apiElements()->where('relation', 'exhibitionsCurrent');
    }

    public function exhibitionsUpcoming()
    {
        return $this->apiElements()->where('relation', 'exhibitionsUpcoming');
    }

    public function exhibitionsUpcomingListing()
    {
        return $this->apiElements()->where('relation', 'exhibitionsUpcomingListing');
    }

    public function homeEvents()
    {
        return $this->belongsToMany('App\Models\Event', 'page_home_event')->withPivot('position')->orderBy('position');
    }

    /**
     * WEB-2254: Finish deprecating homeFeatures relationship
     */
    public function homeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_home_feature')->withPivot('position')->orderBy('position');
    }

    public function mainHomeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_main_home_feature')->withPivot('position')->orderBy('position');
    }

    public function secondaryHomeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_secondary_home_feature')->withPivot('position')->orderBy('position');
    }

    public function homeShopItems()
    {
        return $this->apiElements()->where('relation', 'homeShopItems');
    }

    public function homeArtworks()
    {
        return $this->apiElements()->where('relation', 'homeArtworks');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class)->orderBy('position');
    }

    public function homeArtists()
    {
        return $this->hasMany(HomeArtist::class)->orderBy('position');
    }

    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('position');
    }

    public function dining_hours()
    {
        return $this->hasMany(DiningHour::class)->orderBy('position');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class)->orderBy('position');
    }

    public function families()
    {
        return $this->hasMany(Family::class)->orderBy('position');
    }

    public function featured_hours()
    {
        return $this->hasMany(FeaturedHour::class)->orderBy('position');
    }

    public function whatToExpects()
    {
        return $this->hasMany(WhatToExpect::class)->orderBy('position');
    }

    public function articlesCategories()
    {
        return $this->belongsToMany('App\Models\Category', 'page_article_category')->withPivot('position')->orderBy('position');
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

    public function visitTourPages()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'visit_tour_page')->withPivot('position')->orderBy('visit_tour_page.position', 'asc');
    }

    public function researchResourcesFeaturePages()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_feature_page')->withPivot('position')->orderBy('research_resource_feature_page.position', 'asc');
    }

    public function researchResourcesStudyRooms()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_study_room_pages')->withPivot('position')->orderBy('research_resource_study_room_pages.position', 'asc');
    }

    public function researchResourcesStudyRoomMore()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_study_room_more_pages')->withPivot('position')->orderBy('research_resource_study_room_more_pages.position', 'asc');
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
}

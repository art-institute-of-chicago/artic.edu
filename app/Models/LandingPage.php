<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Admission as Admission;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasBlocks;
use App\Models\LandingPageType;

class LandingPage extends AbstractModel implements Sortable
{
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

    protected $presenter = 'App\Presenters\Admin\LandingPagePresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateLandingPage::class,
    ];

    public function getTypesAttribute()
    {
        $typeModel = new LandingPageType();
        $types = array_values($typeModel->getPageTypes());

        return $types;
    }

    protected $fillable = [
        'published',
        'position',
        'type',
        'title',
        'meta_title',
        'meta_description',
        'search_tags',

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
        'visit_nav_buy_tix_label',
        'visit_nav_buy_tix_link',
        'visit_hours_intro',
        'visit_members_intro',
        'visit_admission_intro',
        'visit_parking_link',
        'visit_parking_label',
        'visit_faqs_label',
        'visit_faqs_link',
        'active',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

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
        10 => 'Dining'
    ];

    public function scopeForType($query, $type)
    {
        return $query->where('type', array_search($type, $this->types));
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
        return $this->belongsToMany('App\Models\Event', 'page_home_event', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    /**
     * WEB-2254: Finish deprecating homeFeatures relationship
     */
    public function homeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_home_feature', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function mainHomeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_main_home_feature', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function secondaryHomeFeatures()
    {
        return $this->belongsToMany('App\Models\HomeFeature', 'page_home_secondary_home_feature', 'landing_page_id')->withPivot('position')->orderBy('position');
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
        return $this->hasMany(Admission::class, 'landing_page_id')->orderBy('position');
    }

    public function homeArtists()
    {
        return $this->hasMany(HomeArtist::class, 'landing_page_id')->orderBy('position');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'landing_page_id')->orderBy('position');
    }

    public function dining_hours() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(DiningHour::class, 'landing_page_id')->orderBy('position');
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'landing_page_id')->orderBy('position');
    }

    public function families()
    {
        return $this->hasMany(Family::class, 'landing_page_id')->orderBy('position');
    }

    public function featured_hours() // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    {
        return $this->hasMany(FeaturedHour::class, 'landing_page_id')->orderBy('position');
    }

    public function whatToExpects()
    {
        return $this->hasMany(WhatToExpect::class, 'landing_page_id')->orderBy('position');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'landing_page_id')->orderBy('position');
    }

    public function articlesCategories()
    {
        return $this->belongsToMany('App\Models\Category', 'page_article_category' . 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function artArticles()
    {
        return $this->belongsToMany('App\Models\Article', 'page_art_article', 'landing_page_id')->withPivot('position')->orderBy('position');
    }
    public function artCategoryTerms()
    {
        return $this->apiElements()->where('relation', 'artCategoryTerms');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_page', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function digitalPublications()
    {
        return $this->belongsToMany('App\Models\DigitalPublication', 'digital_publication_page', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function experiences()
    {
        return $this->belongsToMany('App\Models\Experience', 'experience_page', 'landing_page_id')->withPivot('position')->orderBy('experience_page.position');
    }

    public function printedPublications()
    {
        return $this->belongsToMany('App\Models\PrintedPublication', 'page_printed_publication', 'landing_page_id')->withPivot('position')->orderBy('position');
    }

    public function visitTourPages()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'visit_tour_page')->withPivot('position')->orderBy('visit_tour_page.position', 'asc');
    }

    public function researchResourcesFeaturePages()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_feature_page', 'landing_page_id')->withPivot('position')->orderBy('research_resource_feature_page.position', 'asc');
    }

    public function researchResourcesStudyRooms()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_study_room_pages', 'landing_page_id')->withPivot('position')->orderBy('research_resource_study_room_pages.position', 'asc');
    }

    public function researchResourcesStudyRoomMore()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'research_resource_study_room_more_pages', 'landing_page_id')->withPivot('position')->orderBy('research_resource_study_room_more_pages.position', 'asc');
    }

    public function genericPages()
    {
        return $this->belongsToMany('App\Models\GenericPage', 'landing_page_generic_pages', 'landing_page_id')->withPivot('position')->orderBy('landing_page_generic_pages.position', 'asc');
    }

    public static function getIconTypes()
    {
        return collect(self::$iconTypes);
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
                    return $this->types;
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

<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Page;
use App\Repositories\Behaviors\HandleApiRelations;

class PageRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleFiles, HandleRepeaters, HandleApiRelations, HandleTranslations;

    protected $browsers = [
        // Homepage landing
        'homeEvents' => [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
        ],
        'mainHomeFeatures' => [
            'routePrefix' => 'homepage',
            'moduleName' => 'homeFeatures',
        ],
        'secondaryHomeFeatures' => [
            'routePrefix' => 'homepage',
            'moduleName' => 'homeFeatures',
        ],

        // Visit
        // `visitTourPages` doesn't appear to be in form_visit.blade.php, so I'm not
        // sure this is used anymore. ntrivedi, 05/26/21
        // 'visitTourPages' => [
        //     'moduleName' => 'pages',
        // ],

        // Writing landing
        // `articlesCategories` doesn't appear to be in form_articles_and_publications.blade.php, so I'm not
        // sure this is used anymore. ntrivedi, 05/26/21
        // 'articlesCategories' =>  [
        //     'routePrefix' => 'collection.articles_publications',
        //     'moduleName' => 'categories',
        // ],
        'articles',
        'experiences',
        'printedPublications' => [
            'routePrefix' => 'collection.articles_publications'
        ],
        'digitalPublications' => [
            'routePrefix' => 'collection.articles_publications'
        ],

        // Research landing
        'researchResourcesFeaturePages' => [
            'routePrefix' => 'generic',
            'moduleName' => 'genericPages',
        ],
        'researchResourcesStudyRooms' => [
            'routePrefix' => 'generic',
            'moduleName' => 'genericPages',
        ],
        'researchResourcesStudyRoomMore' => [
            'routePrefix' => 'generic',
            'moduleName' => 'genericPages',
        ],
    ];

    protected $relatedBrowsers = [
        // Homepage landing
        'homeVideos',
        'homeHighlights',
        // `homeExperiences` doesn't appear to be in form_home.blade.php, so I'm not
        // sure it was ever implemented. ntrivedi, 05/26/21
        //'homeExperiences',
    ];

    protected $apiBrowsers = [
        // Homepage landing
        'homeExhibitions' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitions_events'
        ],
        'homeShopItems' => [
            'moduleName' => 'shopItems',
        ],
        'homeArtworks' => [
            'moduleName' => 'artworks',
        ],

        // Exhibition and events landing
        'exhibitionsExhibitions' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitions_events'
        ],
        'exhibitionsCurrent' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitions_events'
        ],
        'exhibitionsUpcoming' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitions_events'
        ],
        'exhibitionsUpcomingListing' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitions_events'
        ],

        // Collection landing
        'artCategoryTerms' => [
            'moduleName' => 'categoryTerms',
            'routePrefix' => 'collection',
        ],

    ];

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeExhibitions', 'position', 'Exhibition');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeEvents', 'position', 'Event');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'mainHomeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'secondaryHomeFeatures', 'position', 'HomeFeature');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeShopItems', 'position', 'ShopItem');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'visitTourPages', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesFeaturePages', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesStudyRooms', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'researchResourcesStudyRoomMore', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsTomany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'printedPublications', 'position', 'PrintedPublication');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'digitalPublications', 'position', 'DigitalPublication');

        $this->hydrateOrderedBelongsTomany($object, $fields, 'homeArtists', 'position', 'HomeArtist');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        // Homepage
        $this->updateRepeater($object, $fields, 'homeArtists', 'HomeArtist');

        // Visits
        $this->updateRepeater($object, $fields, 'admissions', 'Admission');
        $this->updateRepeater($object, $fields, 'locations', 'Location');
        $this->updateRepeater($object, $fields, 'featured_hours', 'FeaturedHour');
        $this->updateRepeater($object, $fields, 'dining_hours', 'DiningHour');
        $this->updateRepeater($object, $fields, 'faqs', 'Faq');
        $this->updateRepeater($object, $fields, 'families', 'Family');
        $this->updateRepeater($object, $fields, 'whatToExpects', 'WhatToExpect');

        // Art & Ideas
        $this->updateMultiBrowserApiRelated($object, $fields, 'featured_items', [
            'articles' => false,
            'experiences' => false
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        // Homepage
        //$fields = $this->getFormFieldsForRepeater($object, $fields, 'homeArtists', 'HomeArtist');

        // Visits
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'admissions', 'Admission');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'locations', 'Location');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'featured_hours', 'FeaturedHour');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'dining_hours', 'DiningHour');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'faqs', 'Faq');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'families', 'Family');
        $fields = $this->getFormFieldsForRepeater($object, $fields, 'whatToExpects', 'WhatToExpect');

        // Art & Ideas
        $fields['browsers']['featured_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'featured_items', [], [
            'articles' => false,
            'experiences' => false
        ]);

        return $fields;
    }

    public function byName($name, $with = [])
    {
        $type = array_search($name, $this->model::$types);
        return $this->model->whereType($type)->with($with)->first();
    }

    public function getFormFieldsForBrowser($object, $relation, $routePrefix = null, $titleKey = 'title', $moduleName = null)
    {
        if ($relation === 'experiences') {
            return $object->$relation->map(function ($relatedElement) use ($titleKey, $routePrefix, $relation, $moduleName) {
                return [
                    'id' => $relatedElement->id,
                    'name' => $relatedElement->titleInBrowser ?? $relatedElement->$titleKey,
                    'edit' => '',
                    'endpointType' => $relatedElement->getMorphClass(),
                ] + (classHasTrait($relatedElement, \App\Models\Behaviors\HasMedias::class) ? [
                    'thumbnail' => $relatedElement->defaultCmsImage(['w' => 100, 'h' => 100]),
                ] : []);
            })->toArray();
        } else {
            return parent::getFormFieldsForBrowser($object, $relation, $routePrefix, $titleKey, $moduleName);
        }

    }
}

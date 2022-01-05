<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Page;
use App\Repositories\Behaviors\HandleApiRelations;

class PageRepository extends ModuleRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleFiles, HandleApiRelations, HandleTranslations;

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
        'articles' => [
            'routePrefix' => 'collection.articles_publications'
        ],
        'experiences' => [
            'routePrefix' => 'collection.interactive_features'
        ],
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

        // Articles and Publications landing
        'featuredJournalArticles',
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
            'routePrefix' => 'collection',
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

    protected $repeaters = [
        // Homepage landing
        'artists' => [
            'relation' => 'homeArtists',
            'model' => 'HomeArtist'
        ],

        // Visit
        'locations',
        'featured_hours' => [
            'relation' => 'featured_hours'
        ],
        'faqs',
        'families',
        'what_to_expects',
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
            return $object->{$relation}->map(function ($relatedElement) use ($titleKey, $routePrefix, $relation, $moduleName) {
                return [
                    'id' => $relatedElement->id,
                    'name' => $relatedElement->titleInBrowser ?? $relatedElement->{$titleKey},
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

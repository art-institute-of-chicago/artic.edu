<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\LandingPage;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class LandingPageRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleRevisions;
    use HandleMedias;
    use HandleFiles;
    use HandleApiRelations;
    use HandleApiBlocks;
    use HandleBlocks {
        HandleApiBlocks::getBlockBrowsers as HandleApiBlocksgetBlockBrowsers;
        HandleBlocks::getBlockBrowsers as HandleBlocksgetBlockBrowsers;
    }

    protected $browsers = [
        // Homepage landing
        'events' => [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
        ],
        'primaryFeatures' => [
            'routePrefix' => 'generic',
            'moduleName' => 'pageFeatures',
        ],
        'secondaryFeatures' => [
            'routePrefix' => 'generic',
            'moduleName' => 'pageFeatures',
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
    ];

    protected $apiBrowsers = [
        'shopItems' => [
            'moduleName' => 'shopItems',
        ],
        'artworks' => [
            'routePrefix' => 'collection',
            'moduleName' => 'artworks',
        ],
        // Collection landing
        'artCategoryTerms' => [
            'moduleName' => 'categoryTerms',
            'routePrefix' => 'collection',
        ],

    ];

    protected $repeaters = [
        'social_links',
        // Homepage landing
        'artists' => [
            'relation' => 'artists',
            'model' => 'HomeArtist'
        ],

        // Visit
        'menu_items',
        'locations',
        'featured_hours' => [
            'relation' => 'featured_hours'
        ],
        'faqs',
        'families',
        'what_to_expects',
    ];

    protected $model;

    public function __construct(LandingPage $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsToMany($object, $fields, 'events', 'position', 'Event');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'primaryFeatures', 'position', 'PageFeature');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'secondaryFeatures', 'position', 'PageFeature');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'shopItems', 'position', 'ShopItem');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'visitTourPages', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'researchResourcesFeaturePages', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsToMany($object, $fields, 'researchResourcesStudyRooms', 'position', 'GenericPage');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'researchResourcesStudyRoomMore', 'position', 'GenericPage');

        $this->hydrateOrderedBelongsToMany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'printedPublications', 'position', 'PrintedPublication');
        $this->hydrateOrderedBelongsToMany($object, $fields, 'digitalPublications', 'position', 'DigitalPublication');

        $this->hydrateOrderedBelongsToMany($object, $fields, 'artists', 'position', 'HomeArtist');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        // Art & Ideas
        $this->updateMultiBrowserApiRelated($object, $fields, 'featured_items', [
            'articles' => false,
            'experiences' => false,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        // Art & Ideas
        $fields['browsers']['featured_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'featured_items', [], [
            'articles' => false,
            'experiences' => false,
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
            return $object->{$relation}->map(function ($relatedElement) use ($titleKey) {
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

    public function getBlockBrowsers($block)
    {
        $apiBlocks = $this->HandleApiBlocksgetBlockBrowsers($block);
        return !empty($apiBlocks) ? $apiBlocks : $this->HandleBlocksgetBlockBrowsers($block);
    }
}

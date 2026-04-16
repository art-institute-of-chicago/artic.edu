<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Page;
use App\Repositories\Behaviors\HandleApiRelations;

class PageRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleRevisions;
    use HandleMedias;
    use HandleFiles;
    use HandleApiRelations;
    use HandleTranslations;

    protected $browsers = [
        // Homepage landing
        'homeEvents' => [
            'routePrefix' => 'exhibitionsEvents',
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

    ];

    protected $relatedBrowsers = [
        // Homepage landing
        'homeVideos',
        'homeHighlights',
        'articlesCategories'
    ];

    protected $apiBrowsers = [
        // Homepage landing
        'homeExhibitions' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitionsEvents'
        ],
        'homeShopItems' => [
            'moduleName' => 'shopItems',
        ],
        'homeArtworks' => [
            'routePrefix' => 'collection',
            'moduleName' => 'artworks',
        ],

        // Exhibition and events landing
        'exhibitionsCurrent' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitionsEvents'
        ],
        'exhibitionsUpcomingListing' => [
            'moduleName' => 'exhibitions',
            'routePrefix' => 'exhibitionsEvents'
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

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        // Art & Ideas
        $this->updateMultiBrowserApiRelated($object, $fields, 'featured_items', [
            'articles' => false,
            'experiences' => false
        ]);

        $this->updateOrderedBelongsTomany($object, $fields, 'articlesCategories', 'position', 'Category');

        parent::afterSave($object, $fields);
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        // Art & Ideas
        $fields['browsers']['featured_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'featured_items', [], [
            'articles' => false,
            'experiences' => false
        ]);

        $fields['browsers']['articlesCategories'] = $this->getFormFieldsForBrowser($object, 'articlesCategories', 'collection.articlesPublications', 'name', 'categories');

        return $fields;
    }

    public function byName($name, $with = [])
    {
        $type = array_search($name, $this->model::$types);

        return $this->model->whereType($type)->with($with)->first();
    }

    public function getFormFieldsForBrowser($object, $relation, $routePrefix = null, $titleKey = 'title', $moduleName = null): array
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

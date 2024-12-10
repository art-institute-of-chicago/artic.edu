<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
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

    protected $browsers = [];

    protected $apiBrowsers = [
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

    protected array $repeaters = [
        'social_links',

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

    protected TwillModelContract $model;

    public function __construct(LandingPage $model)
    {
        $this->model = $model;
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $this->updateMultiBrowserApiRelated($object, $fields, 'featured_items', [
            'articles' => false,
            'experiences' => false,
        ]);

        $this->updateMultiBrowserApiRelated($object, $fields, 'top_stories', [
            'articles' => false,
            'highlights' => false,
            'experiences' => false,
            'videos' => false,
        ]);

        $this->updateMultiBrowserApiRelated($object, $fields, 'most_popular_stories', [
            'articles' => false,
            'highlights' => false,
            'experiences' => false,
            'videos' => false,
        ]);

        parent::afterSave($object, $fields);
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);
        // Art & Ideas
        $fields['browsers']['featured_items'] = $this->getFormFieldsForMultiBrowserApi($object, 'featured_items', [], [
            'articles' => false,
            'experiences' => false,
        ]);

        $fields['browsers']['top_stories'] = $this->getFormFieldsForMultiBrowserApi($object, 'top_stories', [], [
            'articles' => false,
            'highlights' => false,
            'experiences' => false,
            'videos' => false,
        ]);

        $fields['browsers']['most_popular_stories'] = $this->getFormFieldsForMultiBrowserApi($object, 'most_popular_stories', [], [
            'articles' => false,
            'highlights' => false,
            'experiences' => false,
            'videos' => false,
        ]);

        return $fields;
    }

    public function getFormFieldsForBrowser($object, $relation, $routePrefix = null, $titleKey = 'title', $moduleName = null): array
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

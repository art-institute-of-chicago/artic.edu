<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Jobs\ReorderPages;
use App\Models\GenericPage;
use App\Models\Api\Search;
use Illuminate\Support\Arr;

class GenericPageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleApiBlocks, HandleApiRelations, HandleFeaturedRelated {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    protected $browsers = [
        'sponsors' => [
            'routePrefix' => 'exhibitions_events',
        ],
    ];

    public function __construct(GenericPage $model)
    {
        $this->model = $model;
    }

    public function hydrate(TwillModelContract $object, array $fields): TwillModelContract
    {
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');

        return parent::hydrate($object, $fields);
    }

    public function setNewOrder(array $ids): void
    {
        if (is_array(Arr::first($ids))) {
            ReorderPages::dispatch($ids);
        } else {
            parent::setNewOrder($ids);
        }
    }

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        $object->categories()->sync($fields['categories'] ?? []);

        parent::afterSave($object, $fields);
    }

    /**
     * Show data, moved here to allow preview
     */
    public function getShowData($item, $slug = null, $previewPage = null): array
    {
        $navigation = $item->present()->navigation();

        return [
            'nav' => $navigation,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            'title' => $item->title,
            'breadcrumb' => $item->present()->breadCrumb(),
            'blocks' => null,
            'page' => $item,

        ];
    }

    public function searchApi($string, $perPage = null)
    {
        $search = Search::query()->search($string)->published()->resources(['generic-pages', 'static-pages']);

        $results = $search->getSearch($perPage, ['api_model', 'id', 'title', 'web_url']);

        return $results;
    }
}

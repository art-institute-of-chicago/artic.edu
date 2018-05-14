<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;
use App\Jobs\ReorderPages;
use App\Models\GenericPage;
use DB;

class GenericPageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(GenericPage $model)
    {
        $this->model = $model;
    }

    public function setNewOrder($ids)
    {
        if (is_array(array_first($ids))) {
            ReorderPages::dispatch($ids);
        } else {
            parent::setNewOrder($ids);
        }
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'events', 'position', 'Event');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'exhibitions', 'position', 'Exhibition');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->categories()->sync($fields['categories'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['exhibitions']);
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowser($object, $fields, 'articles');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');

        return $fields;
    }

    // Show data, moved here to allow preview
    public function getShowData($item, $slug = null, $previewPage = null)
    {

        $navs = $item->buildNav();

        return [
            'subNav' => $navs['subNav'],
            'nav' => $navs['nav'],
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            "title" => $item->title,
            "breadcrumb" => $item->buildBreadCrumb(),
            "blocks" => null,
            'featuredRelated' => [],
            'page' => $item,

        ];
    }

}

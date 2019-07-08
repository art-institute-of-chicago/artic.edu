<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;

use App\Models\Selection;
use App\Models\Api\Search;

use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

class SelectionRepository extends ModuleRepository
{

    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Selection $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'sidebarEvent', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateBrowser($object, $fields, 'videos', 'position', 'Video');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['sidebarExhibitions']);
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'videos');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');

        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');

        return $fields;
    }

    // Show data, moved here to allow preview
    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'contrastHeader' => $item->present()->contrastHeader,
            'item' => $item,
        ];
    }

}

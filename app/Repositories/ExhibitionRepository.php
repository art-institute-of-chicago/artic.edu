<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;

use App\Repositories\Behaviors\HandleApiBlocks;
use App\Models\Exhibition;
use App\Repositories\Api\BaseApiRepository;

class ExhibitionRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'sidebarEvent', 'position', 'Event');
        $this->hydrateBrowser($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');
        $this->hydrateBrowser($object, $fields, 'videos', 'position', 'Video');

        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['exhibitions', 'shopItems', 'sidebarExhibitions']);
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowser($object, $fields, 'sidebarEvent');
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'videos');

        $this->updateOrderedBelongsTomany($object, $fields, 'sponsors');

        $this->updateRepeater($object, $fields, 'offers', 'Offer');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');
        $fields['browsers']['shopItems'] = $this->getFormFieldsForBrowserApi($object, 'shopItems', 'App\Models\Api\ShopItem', 'general');
        $fields['browsers']['sidebarExhibitions'] = $this->getFormFieldsForBrowserApi($object, 'sidebarExhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events', 'title', 'exhibitions');

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');
        $fields['browsers']['sidebarEvent'] = $this->getFormFieldsForBrowser($object, 'sidebarEvent', 'exhibitions_events', 'title', 'events');
        $fields['browsers']['sponsors'] = $this->getFormFieldsForBrowser($object, 'sponsors', 'exhibitions_events');
        $fields['browsers']['videos'] = $this->getFormFieldsForBrowser($object, 'videos', 'collection.articles_publications');

        $fields = $this->getFormFieldsForRepeater($object, $fields, 'offers', 'Offer');

        return $fields;
    }

    public function getExhibitionTypesList() {
        return collect($this->model::$exhibitionTypes);
    }

    public function getExhibitionStatusesList() {
        return collect($this->model::$exhibitionStatuses);
    }
}

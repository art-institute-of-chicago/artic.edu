<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\ModuleRepository;

use App\Repositories\Behaviors\HandleApiBlocks;
use App\Models\DigitalLabel;
use App\Repositories\Api\BaseApiRepository;

class DigitalLabelRepository extends BaseApiRepository
{
    use HandleSlugs, HandleRevisions, HandleMedias, HandleBlocks, HandleRepeaters, HandleApiBlocks {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

    // public function hydrate($object, $fields)
    // {
    //     $this->hydrateBrowser($object, $fields, 'events', 'position', 'Event');
    //     $this->hydrateBrowser($object, $fields, 'sidebarEvent', 'position', 'Event');
    //     $this->hydrateBrowser($object, $fields, 'articles', 'position', 'Article');
    //     $this->hydrateBrowser($object, $fields, 'sponsors', 'position', 'Sponsor');
    //     $this->hydrateBrowser($object, $fields, 'videos', 'position', 'Video');

    //     return parent::hydrate($object, $fields);
    // }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['digitalLabels']);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields['browsers']['digitalLabels'] = $this->getFormFieldsForBrowserApi($object, 'digitalLabels', 'App\Models\Api\DigitalLabel', 'collection.articles_publications');
        return $fields;
    }
}

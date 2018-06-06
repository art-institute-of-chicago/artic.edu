<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\HomeFeature;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

use App\Repositories\Api\BaseApiRepository;

class HomeFeatureRepository extends ModuleRepository
{
    use  HandleMedias, HandleBLocks, HandleApiBlocks, HandleFiles, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(HomeFeature $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowserApiRelated($object, $fields, ['artworks', 'exhibitions']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');
        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'collection');

        return $fields;
    }

}

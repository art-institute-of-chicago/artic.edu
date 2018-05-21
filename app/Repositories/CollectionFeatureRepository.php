<?php

namespace App\Repositories;


use A17\Twill\Repositories\ModuleRepository;
use App\Models\CollectionFeature;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;

use App\Repositories\Api\BaseApiRepository;

class CollectionFeatureRepository extends ModuleRepository
{

    use  HandleBlocks, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(CollectionFeature $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowser($object, $fields, 'articles');
        $this->updateBrowser($object, $fields, 'selections');
        $this->updateBrowserApiRelated($object, $fields, ['artworks']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['selections'] = $this->getFormFieldsForBrowser($object, 'selections', 'collection');
        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'collection');

        return $fields;
    }


}

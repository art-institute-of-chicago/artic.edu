<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Selection;
use App\Repositories\Behaviors\HandleApiRelations;

class SelectionRepository extends ModuleRepository
{
    use HandleSlugs, HandleMedias, HandleBLocks, HandleApiRelations;

    public function __construct(Selection $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);

        $this->updateBrowserApiRelated($object, $fields, ['artworks']);
        $this->updateBrowser($object, $fields, 'articles');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['artworks'] = $this->getFormFieldsForBrowserApi($object, 'artworks', 'App\Models\Api\Artwork', 'whatson');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'whatson');

        return $fields;
    }

}

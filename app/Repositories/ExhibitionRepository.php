<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;

use App\Models\Exhibition;

class ExhibitionRepository extends ModuleRepository
{
    use HandleRevisions;

    public function __construct(Exhibition $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        return $fields;
    }

}

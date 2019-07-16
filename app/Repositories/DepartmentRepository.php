<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\Department;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\HandleApiRelations;

class DepartmentRepository extends BaseApiRepository
{
    use HandleMedias, HandleApiRelations;

    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateBrowserApiRelated($object, $fields, ['customRelatedArtworks']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['customRelatedArtworks'] = $this->getFormFieldsForBrowserApi($object, 'customRelatedArtworks', 'App\Models\Api\Artwork', 'collection');

        return $fields;
    }

}

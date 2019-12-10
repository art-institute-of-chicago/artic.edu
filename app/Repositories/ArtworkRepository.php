<?php

namespace App\Repositories;

use App\Repositories\Behaviors\HandleFeaturedRelated;
use App\Models\Artwork;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\Handle3DModel;

class ArtworkRepository extends BaseApiRepository
{
    use HandleFeaturedRelated;
    use Handle3DModel;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->handle3DModel($object, $fields);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields = $this->getFormFieldsFor3DModel($object, $fields);

        return $fields;
    }
}

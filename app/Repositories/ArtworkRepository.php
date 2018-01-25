<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use App\Repositories\Api\BaseApiRepository;
use App\Models\Artwork;

class ArtworkRepository extends BaseApiRepository
{
    use HandleSlugs;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);
        $this->updateOrderedBelongsTomany($object, $fields, 'articles');
        $this->updateOrderedBelongsTomany($object, $fields, 'exhibitions');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'siteTags', 'id');

        return $fields;
    }

}

<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Artwork;

class ArtworkRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['site_tags'] ?? []);
        $this->updateOrderedBelongsTomany($object, $fields, 'articles');
        $this->updateOrderedBelongsTomany($object, $fields, 'exhibitions');
        $this->updateOrderedBelongsTomany($object, $fields, 'selections');
        $this->updateOrderedBelongsTomany($object, $fields, 'shopItems');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'site_tags', 'id');

        return $fields;
    }

}

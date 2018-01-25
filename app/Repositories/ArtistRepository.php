<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Artist;

class ArtistRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->siteTags()->sync($fields['siteTags'] ?? []);
        $this->updateBrowser($object, $fields, 'articles');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'siteTags', 'id');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'whatson');
        return $fields;
    }

}

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
        // $this->updateOrderedBelongsTomany($object, $fields, 'shopItems');
        $this->updateBrowser($object, $fields, 'shopItems');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields['browsers']['shopItems'] = $this->getFormFieldsForBrowser($object, 'shopItems', 'whatson');

        return $fields;
    }

}

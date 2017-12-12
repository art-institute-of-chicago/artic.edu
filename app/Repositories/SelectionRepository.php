<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Selection;

class SelectionRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(Selection $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateOrderedBelongsTomany($object, $fields, 'artworks');
        $this->updateOrderedBelongsTomany($object, $fields, 'selections');

        parent::afterSave($object, $fields);
    }

}

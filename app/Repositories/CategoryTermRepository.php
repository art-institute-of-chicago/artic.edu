<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\CategoryTerm;
use App\Repositories\Api\BaseApiRepository;

class CategoryTermRepository extends BaseApiRepository
{
    use HandleMedias;

    public function __construct(CategoryTerm $model)
    {
        $this->model = $model;
    }

    public function beforeSave($object, $fields)
    {
        $object->local_subtype = $fields['subtype'];
        $object->local_title   = $fields['title'];

        return parent::beforeSave($object, $fields);
    }

}

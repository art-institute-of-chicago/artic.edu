<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use App\Models\CategoryTerm;
use App\Repositories\Api\BaseApiRepository;

class CategoryTermRepository extends BaseApiRepository
{
    use HandleMedias;

    public function __construct(CategoryTerm $model)
    {
        $this->model = $model;
    }

    public function beforeSave(TwillModelContract $object, array $fields): void
    {
        $object->local_subtype = $fields['subtype'];
        $object->local_title = $fields['title'];

        parent::beforeSave($object, $fields);
    }
}

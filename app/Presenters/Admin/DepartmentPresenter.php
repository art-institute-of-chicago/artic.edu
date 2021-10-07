<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DepartmentPresenter extends BasePresenter
{
    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function collectionFilteredUrl()
    {
        return route('collection', ['department_ids' => $this->entity->title]);
    }
}

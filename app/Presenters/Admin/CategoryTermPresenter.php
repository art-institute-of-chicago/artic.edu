<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class CategoryTermPresenter extends BasePresenter
{
    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function augmentedTitle() {
        if ($this->entity->getAugmentedModel()) {
            return $this->entity->getAugmentedModel()->title;
        }
    }
}

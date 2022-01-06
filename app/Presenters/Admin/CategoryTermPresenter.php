<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class CategoryTermPresenter extends BasePresenter
{
    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    protected function augmentedTitle()
    {
        if ($this->entity->getAugmentedModel()) {
            return $this->entity->getAugmentedModel()->title;
        }
    }

    protected function collectionUrl()
    {
        switch ($this->entity->subtype) {
            case 'technique':
            case 'theme':
                $value = $this->entity->id;

                break;
            default:
                $value = $this->entity->title;

                break;
        }

        return route('collection', [$this->entity->getParameterName() => $value]);
    }
}

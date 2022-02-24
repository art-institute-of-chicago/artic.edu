<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArtworkTypePresenter extends BasePresenter
{
    protected function collectionUrl()
    {
        $value = $this->entity->id;

        return route('collection', [$this->entity->getParameterName() => $value]);
    }
}

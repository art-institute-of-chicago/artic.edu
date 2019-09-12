<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class InteractiveFeaturePresenter extends BasePresenter
{

    public function updatedDate()
    {
        if ($this->entity->updated_at) {
            return $this->entity->updated_at->format('M j, Y \a\t g:ia');
        }
    }

}

<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ExperiencePresenter extends BasePresenter
{
    public function isWebPublished()
    {
        return ($this->entity->is_published && !$this->entity->kiosk_only) ? 'Yes' : 'No';
    }

    public function url()
    {
        return route('interactiveFeatures.show', $this->entity->getSlug());
    }
}

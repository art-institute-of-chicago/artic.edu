<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class LightboxPresenter extends BasePresenter
{
    public function lightboxStartDate()
    {
        if ($this->entity->lightbox_start_date) {
            return $this->entity->lightbox_start_date->format('M j, Y');
        }
    }

    public function lightboxEndDate()
    {
        if ($this->entity->lightbox_end_date) {
            return $this->entity->lightbox_end_date->format('M j, Y');
        }
    }
}

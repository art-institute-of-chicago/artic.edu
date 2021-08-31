<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class VideoPresenter extends BasePresenter
{
    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }
}

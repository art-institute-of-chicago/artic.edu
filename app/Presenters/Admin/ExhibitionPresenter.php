<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ExhibitionPresenter extends BasePresenter
{
    public function startDate()
    {
        if ($this->entity->start_date) {
            return $this->entity->start_date->format('d M, Y');
        }

    }
}

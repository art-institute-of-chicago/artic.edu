<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IssuePresenter extends BasePresenter
{

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

}

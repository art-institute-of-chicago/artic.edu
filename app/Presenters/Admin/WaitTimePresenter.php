<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class WaitTimePresenter extends BasePresenter
{
    public function display()
    {
        return $this->entity->wait_display ?? $this->entity->display;
    }
}

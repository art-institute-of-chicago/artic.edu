<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IlluminatedLinkPresenter extends BasePresenter
{
    public function title_display()
    {
        return $this->title;
    }

    public function list_description()
    {
        return $this->description;
    }
}

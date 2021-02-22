<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DigitalPublicationSectionPresenter extends BasePresenter
{
    public function type()
    {
        if ($this->entity->type) {
            return \App\Models\DigitalPublicationSection::$types[$this->entity->type];
        }
    }
}

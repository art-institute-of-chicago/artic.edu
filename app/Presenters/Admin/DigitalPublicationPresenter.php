<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{

    private $sectionsForLanding;

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function sectionsForLanding()
    {
        return $this->sectionsForLanding ?? $this->sectionsForLanding = $this->entity->sections()
            ->published()
            ->get();
    }
}

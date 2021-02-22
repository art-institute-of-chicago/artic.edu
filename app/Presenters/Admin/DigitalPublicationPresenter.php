<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{

    private $aboutsForLanding;
    private $textsForLanding;
    private $galleriesForLanding;

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function aboutsForLanding()
    {
        return $this->aboutsForLanding ?? $this->aboutsForLanding = $this->entity->sections()
            ->abouts()
            ->published()
            ->get();
    }

    public function textsForLanding()
    {
        return $this->textsForLanding ?? $this->textsForLanding = $this->entity->sections()
            ->texts()
            ->published()
            ->get();
    }

    public function galleriesForLanding()
    {
        return $this->galleriesForLanding ?? $this->galleriesForLanding = $this->entity->sections()
            ->galleries()
            ->published()
            ->get();
    }
}

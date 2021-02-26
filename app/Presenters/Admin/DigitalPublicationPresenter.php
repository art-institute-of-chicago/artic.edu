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

    public function sectionsForLanding($type = 'about')
    {
        return $this->{$type . 'sForLanding'} ?? $this->{$type . 'sForLanding'} = $this->entity
            ->sections()
            ->sections($type)
            ->published()
            ->get();
    }
}

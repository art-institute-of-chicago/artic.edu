<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class SelectionPresenter extends BasePresenter
{
    public function artworksCount()
    {
        return $this->entity->artworks()->count();
    }

    public function headerType()
    {
        return "hero";
    }

    public function type()
    {
        if ($this->entity->siteTags->first()) {
            return $this->entity->type = $this->entity->siteTags->first()->name;
        } else {
            return 'Highlights'; // for detail header
        }
    }

}

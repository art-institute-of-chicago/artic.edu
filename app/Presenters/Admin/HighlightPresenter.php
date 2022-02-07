<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class HighlightPresenter extends BasePresenter
{
    public function artworksCount()
    {
        return $this->entity->artworks()->count();
    }

    public function headerType()
    {
        return 'hero';
    }

    public function type()
    {
        if ($this->entity->siteTags->first()) {
            return $this->entity->type = $this->entity->siteTags->first()->name;
        }

            return 'Highlights'; // For detail header

    }

    public function url()
    {
        return route('highlights.show', $this->entity);
    }
}

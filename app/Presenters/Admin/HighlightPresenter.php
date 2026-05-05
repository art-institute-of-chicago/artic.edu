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
        return 'Highlights'; // For detail header
    }

    public function url()
    {
        return route('highlights.show', $this->entity);
    }
}

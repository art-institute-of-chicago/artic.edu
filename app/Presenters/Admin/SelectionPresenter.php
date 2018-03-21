<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class SelectionPresenter extends BasePresenter
{
    public function artworksCount()
    {
        return $this->artworks->count();
    }

    public function headerType()
    {
        return "hero";
    }

}

<?php

namespace App\Presenters\Admin;

use App\Helpers\NavHelpers;

class JournalPresenter extends GenericPresenter
{
    private $navCache;

    private function getNav()
    {
        return $navCache ?? $navCache = NavHelpers::get_nav_for_publications($this->entity->title);
    }

    public function breadCrumb()
    {
        return $this->getNav()['breadcrumb'] ?? [];
    }


    public function navigation()
    {
        return $this->getNav()['nav'] ?? [];
    }
}

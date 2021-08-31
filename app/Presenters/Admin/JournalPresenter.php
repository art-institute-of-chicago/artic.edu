<?php

namespace App\Presenters\Admin;


class JournalPresenter extends GenericPresenter
{

    private $navCache;

    private function getNav()
    {
        return $navCache ?? $navCache = get_nav_for_publications($this->entity->title);
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

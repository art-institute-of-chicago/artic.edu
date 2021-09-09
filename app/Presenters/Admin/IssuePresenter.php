<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IssuePresenter extends BasePresenter
{
    private $articlesForLanding;

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function articlesForLanding()
    {
        return $this->articlesForLanding ?? $this->articlesForLanding = $this->entity->articles()
            ->ordered()
            ->published()
            ->get();
    }
}

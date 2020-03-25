<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IssuePresenter extends BasePresenter
{

    private $editorsNote;

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
            ->where('type', '!=' ,'editors-note')
            ->published()
            ->get();
    }

    public function editorsNote()
    {
        return $this->editorsNote ?? $this->editorsNote = $this->entity->articles()
            ->where('type', 'editors-note')
            ->published()
            ->first();
    }

}

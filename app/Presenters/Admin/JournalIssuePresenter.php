<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class JournalIssuePresenter extends BasePresenter
{

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function issueNumber()
    {
        if ($this->entity->issueNumber) {
            return sprintf("%02d", $this->entity->issueNumber);
        }
    }

}

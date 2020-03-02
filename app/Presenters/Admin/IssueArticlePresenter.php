<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class IssueArticlePresenter extends BasePresenter
{

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function issueNumber()
    {
        if ($this->entity->issue) {
            return $this->entity->issue->present()->issueNumber;
        }
    }

}

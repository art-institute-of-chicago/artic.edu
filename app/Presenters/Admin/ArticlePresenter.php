<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArticlePresenter extends BasePresenter
{
    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Article::LARGE:
                return "feature";
                break;
            default:
                return null;
                break;
        }
    }

}

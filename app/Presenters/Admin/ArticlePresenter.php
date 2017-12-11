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

}

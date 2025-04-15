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
        return '';
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Article::LARGE:
                return 'feature';

                break;
            default:
                return null;

                break;
        }
    }

    public function url()
    {
        return route('articles.show', $this->entity);
    }

    public function itemprops()
    {
        return [
            'publisher' => 'Art Institute of Chicago',
        ];
    }
}

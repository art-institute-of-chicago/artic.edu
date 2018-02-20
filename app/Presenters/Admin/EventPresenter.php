<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class EventPresenter extends BasePresenter
{
    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function type()
    {
        return \App\Models\Event::$eventTypes[$this->entity->type];
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Event::LARGE_LAYOUT:
                return "feature";
                break;
            case \App\Models\Event::BASIC_LAYOUT:
                return null;
                break;
        }
    }

}

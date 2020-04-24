<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class VideoPresenter extends BasePresenter
{
    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function url()
    {
        return route('videos.show', $this->entity);
    }
}

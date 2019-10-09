<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class HoursPresenter extends BasePresenter
{

    public function validFrom()
    {
        if ($this->entity->valid_from) {
            return $this->entity->valid_from->format('M j, Y');
        }
    }

    public function validThrough()
    {
        if ($this->entity->valid_through) {
            return $this->entity->valid_through->format('M j, Y');
        }
    }

    public function type() {
        return Hour::$types[$this->entity->type];
    }

}

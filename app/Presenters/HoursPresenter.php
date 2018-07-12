<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class HoursPresenter extends BasePresenter
{

    public function presentOpeningTime() {
        if ($this->entity->opening_time)
            return $this->entity->opening_time->format('g:i');
    }

    public function presentClosingTime() {
        if ($this->entity->closing_time)
            return $this->entity->closing_time->format('g:i');
    }

    public function dayOfWeek() {
        return Hour::$days[$this->entity->day_of_week];
    }

    public function presentType() {
        return Hour::$types[$this->entity->type];
    }

    public function presentClosed() {
        if ($this->entity->closed) {
            return 'Closed';
        } else {
            return 'Open';
        }
    }

}

<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class HoursPresenter extends BasePresenter
{

    public function presentOpeningTime() {
        return (new Carbon($this->entity->opening_time))->format('H:i');
    }

    public function presentClosingTime() {
        return (new Carbon($this->entity->closing_time))->format('H:i');
    }

    public function dayOfWeek() {
        return Hour::$days[$this->entity->day_of_week];
    }

    public function presentType() {
        return Hour::$types[$this->entity->type];
    }

}

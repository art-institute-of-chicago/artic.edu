<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class ClosurePresenter extends BasePresenter
{

    public function presentStartDate() {
        return (new Carbon($this->entity->start_date))->format('d M, Y');
    }

    public function presentEndDate() {
        return (new Carbon($this->entity->end_date))->format('d M, Y');
    }

    public function presentType() {
        return Hour::$types[$this->entity->type];
    }

}

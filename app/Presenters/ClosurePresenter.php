<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class ClosurePresenter extends BasePresenter
{

    public function presentStartDate() {
        if ($this->entity->date_start)
            return $this->entity->date_start->format('d M, Y');
    }

    public function presentEndDate() {
        if ($this->entity->date_end)
            return $this->entity->date_end->format('d M, Y');
    }

    public function presentType() {
        return Hour::$types[$this->entity->type];
    }

}

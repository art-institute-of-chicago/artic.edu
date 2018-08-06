<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Closure;
use Carbon\Carbon;

class ClosurePresenter extends BasePresenter
{

    public function presentStartDate() {
        if ($this->entity->date_start)
            return $this->entity->date_start->format('M j, Y');
    }

    public function presentEndDate() {
        if ($this->entity->date_end)
            return $this->entity->date_end->format('M j, Y');
    }

    public function presentType() {
        return Closure::$types[$this->entity->type];
    }

}

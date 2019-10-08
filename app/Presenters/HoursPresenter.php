<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;
use App\Models\Hour;
use Carbon\Carbon;

class HoursPresenter extends BasePresenter
{

    public function presentType() {
        return Hour::$types[$this->entity->type];
    }

}

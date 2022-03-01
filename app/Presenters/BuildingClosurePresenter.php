<?php

namespace App\Presenters;

use App\Models\BuildingClosure;

class BuildingClosurePresenter extends BasePresenter
{
    public function presentStartDate()
    {
        if ($this->entity->date_start) {
            return $this->entity->date_start->format('M j, Y');
        }
    }

    public function presentEndDate()
    {
        if ($this->entity->date_end) {
            return $this->entity->date_end->format('M j, Y');
        }
    }

    public function presentType()
    {
        return BuildingClosure::$types[$this->entity->type];
    }

    public function closureCopy()
    {
        $closure_copy = $this->entity->closure_copy;
        $closure_copy = str_replace('<p>', ' ', $closure_copy);
        $closure_copy = str_replace('</p>', ' ', $closure_copy);

        return $closure_copy;
    }
}

<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ExhibitionPresenter extends BasePresenter
{
    public function startDate()
    {
        if ($this->entity->start_date) {
            return $this->entity->start_date->format('d M, Y');
        }
    }

    public function date()
    {
        $start = $this->entity->asDateTime($this->start_at);
        $end   = $this->entity->asDateTime($this->end_at);

        return $start->format('m d Y') . ' - ' . $end->format('m d Y');
    }

    public function exhibitionType()
    {
        return ($this->entity->cms_exhibition_type == \App\Models\Exhibition::SPECIAL) ? "Special Exhibition" : 'Exhibition';
    }
}

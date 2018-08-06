<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class VideoPresenter extends BasePresenter
{
    public function startDate()
    {
        if ($this->entity->start_date) {
            return $this->entity->start_date->format('M j, Y');
        }
    }

    public function date()
    {
        $start = $this->entity->asDateTime($this->start_at);
        $end   = $this->entity->asDateTime($this->end_at);

        return $start->format('m d Y') . ' - ' . $end->format('m d Y');
    }

    public function videoBlock()
    {
        return [
            'type' => 'embed',
            'size' => 'l',
            'media' => $this->entity->toArray(),
            "poster" => $this->entity->imageFront('hero'),
            'hideCaption' => true,
            'fullscreen' => false
        ];
    }

}

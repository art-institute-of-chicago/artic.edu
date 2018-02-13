<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
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

    public function headerType()
    {
        switch ($this->entity->cms_exhibition_type) {
            case \App\Models\Exhibition::SPECIAL:
                return "super-hero";
                break;
            case \App\Models\Exhibition::LARGE:
                return "feature";
                break;
            case \App\Models\Exhibition::BASIC:
                return null;
                break;
        }
    }

    public function startAt()
    {
        return new Carbon($this->entity->start_at);
    }

    public function endAt()
    {
        return new Carbon($this->entity->end_at);
    }

    public function navigation()
    {
        return array_filter([$this->galleryLink(), $this->relatedEventsLink(), $this->closingSoonLink()]);
    }

    protected function galleryLink() {
        return [
            'label' => $this->entity->gallery_title,
            'href'  => '#',
            'iconBefore' => 'location'
        ];
    }

    protected function relatedEventsLink() {
        $count = $this->entity->eventsCount();
        return [
            'label' =>  $count . ' related ' . str_plural('event', $count),
            'href' => '#related_events',
            'iconBefore' => 'calendar'
        ];
    }

    protected function closingSoonLink() {
        return [
            'label' => 'Closing Soon',
            'variation' => 'closing-soon'
        ];
    }
}

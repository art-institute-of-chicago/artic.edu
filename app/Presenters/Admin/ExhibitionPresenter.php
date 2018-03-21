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

    public function exhibitionType()
    {
        if ($this->entity->cms_exhibition_type == \App\Models\Exhibition::SPECIAL) {
            return 'Special Exhibition';
        } else {
            if ($this->entity->ongoing) {
                return 'Ongoing';
            } else {
                return 'Exhibition';
            }
        }
    }

    // public function timing()
    // {
    //     // If started less than 2 weeks ago
    //     if (Carbon::now()->between($this->startAt(), $this->startAt()->addWeeks(2)) {
    //         return 'Now Open';
    //     }

    //     if (Carbon::now()->between($this->endAt()->subWeeks(2), $this->endAt()) {
    //         return 'Closing soon';
    //     }
    // }

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
        if ($this->entity->gallery_id) {
            return [
                'label' => $this->entity->gallery_title,
                'href'  => route('galleries.show', $this->entity->gallery_id),
                'iconBefore' => 'location'
            ];
        }
    }

    protected function relatedEventsLink() {
        $count = $this->entity->eventsCount();

        if ($count > 0) {
            return [
                'label' =>  $count . ' related ' . str_plural('event', $count),
                'href' => '#related_events',
                'iconBefore' => 'calendar'
            ];
        }
    }

    protected function closingSoonLink() {
        if ($this->entity->closingSoon) {
            return [
                'label' => 'Closing Soon',
                'variation' => 'closing-soon'
            ];
        }
    }

    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }
}

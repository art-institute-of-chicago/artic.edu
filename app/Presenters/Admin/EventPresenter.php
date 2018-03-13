<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class EventPresenter extends BasePresenter
{
    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function type()
    {
        return \App\Models\Event::$eventTypes[$this->entity->type];
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Event::LARGE_LAYOUT:
                return "feature";
                break;
            case \App\Models\Event::BASIC_LAYOUT:
                return null;
                break;
        }
    }

    public function ticketStatus()
    {
        if ($this->entity->is_private) {
            return 'rsvp';
        }

        if ($this->entity->is_member_exclusive) {
            return 'register';
        }

        if ($this->entity->is_free) {
            return 'free';
        }

        if ($this->entity->is_ticketed) {
            if ($this->entity->is_sold_out) {
                return 'sold-out';
            } else {
                return 'buy-ticket';
            }
        }
    }

    public function formattedNextOcurrence()
    {
        if (!empty($this->entity->forced_date)) {
            return $this->entity->forced_date;
        } else {
            if ($next = $this->entity->nextOcurrence) {
                return $next->date->format('F j, Y h:ia') . '&ndash;' . $next->date_end->format('h:ia');
            }
        }
    }

    public function nextOcurrenceDate()
    {
        if ($next = $this->entity->nextOcurrence) {
            return $next->date->format('F j, Y');
        }
    }

    public function nextOcurrenceTime()
    {
        if ($next = $this->entity->nextOcurrence) {
            return $next->date->format('h:ia') . ' &ndash; ' . $next->date_end->format('h:ia');
        }
    }

    public function navigation()
    {
        return array_filter([$this->locationLink(), $this->registrationRequired()]);
    }

    protected function locationLink() {
        if ($this->entity->location) {
            return [
                'label' => $this->entity->location,
                'iconBefore' => 'location'
            ];
        }
    }

    protected function registrationRequired() {
        return [
            'label' => 'Registration required',
            'variation' => 'user'
        ];
    }

}

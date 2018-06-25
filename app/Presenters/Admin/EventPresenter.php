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
        if ($this->entity->type) {
            return \App\Models\Event::$eventTypes[$this->entity->type];
        }
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
        if (empty($this->nextOcurrence)) {
            return null;
        }

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
                return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('F j, Y h:ia').'</time> &ndash; <time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('h:ia').'</time>';
            } elseif ($last = $this->entity->lastOcurrence) {
                return '<time datetime="'.$last->date->format("c").'" itemprop="startDate">'.$last->date->format('F j, Y h:ia').'</time> &ndash; <time datetime="'.$last->date_end->format("c").'" itemprop="endDate">'.$last->date_end->format('h:ia').'</time>';
            }
        }
    }

    public function nextOcurrenceDate()
    {
        if ($next = $this->entity->nextOcurrence) {
            return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('M j, Y').'</time>';
        }
    }

    public function nextOcurrenceTime()
    {
        if ($next = $this->entity->nextOcurrence) {
            return '<time datetime="'.$next->date->format("H:i:s").'" itemprop="startDate">'.$next->date->format('h:ia').'</time> &ndash; <time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('h:ia').'</time>';
        }
    }

    public function navigation()
    {
        return array_filter([$this->locationLink(), $this->registrationRequired()]);
    }

    public function itemprops() {
        return [
            'isAccessibleForFree' => ($this->entity->ticketStatus === 'free') ? 'true' : 'false',
        ];
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
        if ($this->entity->is_member_exclusive) {
            return [
                'label' => 'Registration required',
                'iconBefore' => 'pencil',
                'variation' => 'user'
            ];
        }
    }

}

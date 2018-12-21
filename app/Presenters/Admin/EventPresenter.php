<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;

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
        if ($this->entity->event_type) {
            return \App\Models\Event::$eventTypes[$this->entity->event_type];
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
        if ($this->nextOcurrence == null) {
            return null;
        }

        if ($this->entity->is_sold_out) {
            return 'sold-out';
        }

        if ($this->entity->is_private) {
            return 'rsvp';
        }

        if ($this->entity->is_registration_required) {
            return 'register';
        }

        if ($this->entity->is_free) {
            if ($this->entity->is_ticketed) {
                return 'rsvp';
            } else {
                return 'free';
            }
        }

        if ($this->entity->is_ticketed) {
            return 'buy-ticket';
        }
    }

    public function formattedNextOcurrence()
    {
        if (!empty($this->entity->forced_date)) {
            return $this->entity->forced_date;
        } else {
            if ($next = $this->entity->nextOcurrence) {

                return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('F j, Y | g:i').'</time>&ndash;<time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('g:i').'</time>';
            } elseif ($last = $this->entity->lastOcurrence) {
                return '<time datetime="'.$last->date->format("c").'" itemprop="startDate">'.$last->date->format('F j, Y | g:i').'</time>&ndash;<time datetime="'.$last->date_end->format("c").'" itemprop="endDate">'.$last->date_end->format('g:i').'</time>';
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

            return '<time datetime="'.$next->date->format("c").'" itemprop="startDate">'.$next->date->format('g:i').'</time>&ndash;<time datetime="'.$next->date_end->format("c").'" itemprop="endDate">'.$next->date_end->format('g:i').'</time>';
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
                'iconBefore' => 'location',
                'itemprop' => 'location'
            ];
        }
    }

    protected function registrationRequired() {
        if ($this->entity->is_registration_required) {
            return [
                'label' => 'Registration required',
                'iconBefore' => 'pencil',
                'variation' => 'user'
            ];
        }
    }

    public function buyButtonText()
    {
        if ($this->entity->buy_button_text) {
            return $this->entity->buy_button_text;
        }

        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        if ($this->entity->is_sold_out || ($ticketedEvent->available ?? 1) < 1) {
            return 'Sold out';
        }

        if ($this->entity->is_free) {
            return 'RSVP';
        }

        if ($this->entity->is_member_exclusive) {
            return 'Member Exclusive';
        }

        if ($this->entity->is_registration_required) {
            return 'Register';
        }

        return 'Buy tickets';
    }

    public function buyButtonCaption()
    {
        $caption = $this->entity->buy_button_caption ?? '';

        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        if ($ticketedEvent->on_sale_at ?? false && $ticketedEvent->off_sale_at ?? false)
        {
            $caption = sprintf(
                '<p>Registration Period: %s—%s</p>',
                (new Carbon($ticketedEvent->on_sale_at))->format('F j'),
                (new Carbon($ticketedEvent->off_sale_at))->format('F j')
            ) . ($caption ? '<p><br></p>' . $caption : '');
        }

        return $caption;
    }

    public function imageUrl() {
        $settings = aic_imageSettings([
            'image' => $this->entity->imageFront('hero'),
            'settings' => [
                'srcset' => array(1200),
                'sizes' => '1200px',
            ],
        ]);

        return str_before($settings['srcset'], ' ');
    }
}

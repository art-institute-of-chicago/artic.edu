<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;
use App\Helpers\ImageHelpers;
use Illuminate\Support\Str;

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
            return \App\Models\Event::$eventTypes[$this->entity->event_type] ?? null;
        }
    }

    public function headerType()
    {
        switch ($this->entity->layout_type) {
            case \App\Models\Event::LARGE_LAYOUT:
                return 'feature';

                break;
            case \App\Models\Event::BASIC_LAYOUT:
                return null;

                break;
        }
    }

    public function ticketStatus()
    {
        if ($this->nextOccurrence == null) {
            return null;
        }

        if ($this->isSoldOut) {
            return 'sold-out';
        }

        if ($this->entity->is_private) {
            return 'rsvp';
        }

        if ($this->entity->is_registration_required) {
            return 'register';
        }

        if ($this->entity->is_free) {
            return 'free';
        }

        if ($this->entity->is_rsvp) {
            return 'rsvp';
        }

        if ($this->isTicketed) {
            return 'buy-ticket';
        }
    }

    protected function formatDate($date)
    {
        return '<time datetime="' . $date->format('c') . '" itemprop="startDate">' . $date->format('l, F j') . '</time>';
    }

    public function formattedBlockDate()
    {
        if (!empty($this->entity->forced_date)) {
            return $this->entity->forced_date;
        }
        // EventRepository::getEventsFiltered() adds this from `event_metas`
        if (isset($this->entity->date)) {
            return $this->formatDate($this->entity->date);
        }
    }

    public function formattedNextOccurrence()
    {
        if (!empty($this->entity->forced_date)) {
            return $this->entity->forced_date;
        }

        if ($next = $this->entity->nextOccurrenceExclusive) {
            return '<time datetime="' . $next->date->format('c') . '" itemprop="startDate">' . $next->date->format('F j, Y | g:i') . '</time>&ndash;<time datetime="' . $next->date_end->format('c') . '" itemprop="endDate">' . $next->date_end->format('g:i') . '</time>';
        }

        if ($last = $this->entity->lastOccurrence) {
            return '<time datetime="' . $last->date->format('c') . '" itemprop="startDate">' . $last->date->format('F j, Y | g:i') . '</time>&ndash;<time datetime="' . $last->date_end->format('c') . '" itemprop="endDate">' . $last->date_end->format('g:i') . '</time>';
        }
    }

    public function nextOccurrenceDate()
    {
        if ($next = $this->entity->nextOccurrence) {
            return $this->formatDate($next->date);
        }
    }

    public function nextOccurrenceTime()
    {
        if ($next = $this->entity->nextOccurrence) {
            return '<time datetime="' . $next->date->format('c') . '" itemprop="startDate">' . $next->date->format('g:i') . '</time>&ndash;<time datetime="' . $next->date_end->format('c') . '" itemprop="endDate">' . $next->date_end->format('g:i') . '</time>';
        }
    }

    public function navigation()
    {
        return array_filter([$this->locationLink(), $this->registrationRequired()]);
    }

    public function itemprops()
    {
        return [
            'isAccessibleForFree' => ($this->entity->ticketStatus === 'free') ? 'true' : 'false',
        ];
    }

    protected function locationLink()
    {
        if ($this->entity->location) {
            return [
                'label' => $this->entity->location,
                'iconBefore' => 'location',
                'itemprop' => 'location'
            ];
        }
    }

    protected function registrationRequired()
    {
        if ($this->entity->is_registration_required) {
            return [
                'label' => 'Registration required',
                'iconBefore' => 'pencil',
                'variation' => 'user'
            ];
        }
    }

    public function isTicketed()
    {
        if (!$this->entity->is_ticketed) {
            return false;
        }

        if ($this->entity->is_sales_button_hidden) {
            return false;
        }

        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        return (!isset($ticketedEvent))
            || (!$ticketedEvent->on_sale_at)
            || (
                (
                    ($ticketedEvent->on_sale_at ?? false) && (
                        (new Carbon($ticketedEvent->on_sale_at))->lessThan(Carbon::now())
                    )
                ) && (
                    ($ticketedEvent->off_sale_at ?? false) && (
                        (new Carbon($ticketedEvent->off_sale_at))->greaterThan(Carbon::now())
                    )
                )
            );
    }

    /**
     * WEB-414: Do not use this in the API. Replicate this logic in the aggregator for touches.
     */
    public function isSoldOut()
    {
        $ticketedEvent = $this->entity->apiModels('ticketedEvent', 'TicketedEvent')->first();

        return $this->entity->is_sold_out || ($ticketedEvent->available ?? 1) < 1;
    }

    public function buyButtonText()
    {
        if ($this->isSoldOut()) {
            return 'Sold Out';
        }

        if ($this->entity->buy_button_text) {
            return $this->entity->buy_button_text;
        }

        return 'Buy Tickets';
    }

    public function imageUrl()
    {
        $settings = ImageHelpers::aic_imageSettings([
            'image' => $this->entity->imageFront('hero'),
            'settings' => [
                'srcset' => [1200],
                'sizes' => '1200px',
            ],
        ]);

        return Str::before($settings['srcset'], ' ');
    }
}

<?php

namespace App\Http\Transformers;

class EventOccurrenceTransformer extends ApiTransformer
{
    public function transform($item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'short_description' => $this->getString($item->list_description),
            'description' => $item->present()->copy(),
            'image_url' => $item->present()->imageUrl() ?? null,
            'image_caption' => $item->hero_caption,
            'is_private' => (bool) $item->is_private,
            'location' => $item->location,
            'start_at' => $this->getStartAt($item),
            'end_at' => $this->getEndAt($item),
            'button_text' => $item->present()->buyButtonText(),
            'button_url' => $item->buy_tickets_link,
            'button_caption' => $item->buy_button_caption,
            'created_at' => $item->created_at->toIso8601String(),
            'updated_at' => $item->updated_at->toIso8601String(),
        ];
    }

    /**
     * This is actually broken in the /events API too!
     *
     * @see App\Http\Transformers\EventTransformer.php
     */
    private function getEndAt($item)
    {
        if (!isset($item->date)) {
            return null;
        }

        $matchingDateRange = $item->all_dates->first(function ($dateRange, $key) use ($item) {
            return isset($dateRange['date']) && $dateRange['date']->isSameDay($item->date);
        });

        if ($matchingDateRange && isset($matchingDateRange['date_end'])) {
            return $matchingDateRange['date_end']->toIso8601String();
        }

        return null;
    }

    private function getStartAt($item)
    {
        if (!isset($item->date)) {
            return null;
        }

        $matchingDateRange = $item->all_dates->first(function ($dateRange, $key) use ($item) {
            return isset($dateRange['date']) && $dateRange['date']->isSameDay($item->date);
        });

        if ($matchingDateRange && isset($matchingDateRange['date'])) {
            return $matchingDateRange['date']->toIso8601String();
        }

        return null;
    }

    // WEB-2258: Transition to using Datum for outbound transformers!!!
    private function getString($value)
    {
        if (!isset($value)) {
            return null;
        }

        // WEB-1053: `list_description` is WYSIWYG, `short_description` was not
        $value = strip_tags($value);

        // Remove &nbsp;
        $value = str_replace('&nbsp;', '', $value);

        $value = trim($value);

        if (empty($value)) {
            return null;
        }

        return $value;
    }
}

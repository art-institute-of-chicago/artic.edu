<?php

namespace App\Http\Transformers;

use App\Models\Collections\Exhibition;

class EventOccurrenceTransformer extends ApiTransformer
{

    public function transform($item)
    {
        // return $item->toArray();

        return [
            'id' => $item->id,
            'title' => $item->title,
            'short_description' => $this->getString($item->short_description),
            'description' => $item->present()->copy(),
            'image_url' => $item->image('hero'),
            'image_caption' => $item->hero_caption,
            'is_private' => (bool) $item->is_private,
            'location' => $item->location,
            'start_at' => $item->date->toIso8601String(),
            'end_at' => $this->getEndAt($item),
            'button_text' => $item->present()->buyButtonText(),
            'button_url' => $item->buy_tickets_link,
            'button_caption' => $item->buy_button_caption,
            'created_at' => $item->created_at->toIso8601String(),
            'updated_at' => $item->updated_at->toIso8601String(),
        ];
    }

    // This is actually broken in the /events API too!
    private function getEndAt($item)
    {
        if (!isset($item->date)) {
            return null;
        }

        $matchingDateRange = $item->all_dates->first( function($dateRange, $key) use ($item) {
            return isset($dateRange['date']) && $dateRange['date']->eq( $item->date );
        });

        if ($matchingDateRange && isset($matchingDateRange['date_end'])) {
            return $matchingDateRange['date_end']->toIso8601String();
        }

        return null;
    }

    // TODO: Transition to using Datum for outbound transformers!!!
    private function getString($value)
    {
        if (!isset($value)) {
            return null;
        }

        $value = trim($value);

        if (empty($value)) {
            return null;
        }

        return $value;
    }

}

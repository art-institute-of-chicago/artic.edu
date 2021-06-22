<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;
use Illuminate\Support\Str;

class ExhibitionPresenter extends BasePresenter
{
    public function startDate()
    {
        if ($this->entity->start_date) {
            return $this->entity->start_date->format('M j, Y');
        }
    }

    // Passed to _m-article-header--* in exhibitionDetail.blade.php
    // Dead code? Template calls ->format on the string returned here
    // Used in App\Http\Controllers\Admin\ExhibitionController
    public function date()
    {
        $date = "";

        // Strangely, we cannot use isset() or empty() here
        $hasStart = $this->aic_start_at !== null;
        $hasEnd = $this->aic_end_at !== null;

        // These default gracefully to `now` if the attrs are empty
        $start = $this->entity->asDateTime($this->aic_start_at);
        $end = $this->entity->asDateTime($this->aic_end_at);

        if ($hasStart) {
            $date .= $start->format('m d Y');
        }

        if ($hasStart && $hasEnd) {
            $date .= '–';
        }

        if ($hasEnd){
            $date .= $end->format('m d Y');
        }

        return $date;
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
        return $this->entity->isOngoing ? 'Ongoing' : 'Exhibition';
    }

    // Used in _m-listing----exhibition-history-row
    public function formattedDateCanonical()
    {
        return view('components.organisms._o-public-dates' , [
            'formattedDate' => $this->date_display_override,
            'dateStart' => $this->dateStart, // see getter
            'dateEnd' => $this->dateEnd, // see getter
            'date' => $this->date,
        ]);
    }

    // Used in member magazine
    public function formattedDate()
    {
        return view('components.organisms._o-public-dates' , [
            'formattedDate' => $this->date_display_override,
            'dateStart' => $this->startAt,
            'dateEnd' => $this->endAt,
            'date' => $this->date,
            'font' => '', // defaults to f-secondary
        ]);
    }

    public function startAt()
    {
        if ($this->entity->public_start_date != null) {
            return $this->entity->public_start_date;
        }
        elseif ($this->entity->aic_start_at != null) {
            return new Carbon($this->entity->aic_start_at);
        }
        else {
            return "";
        }
    }

    public function endAt()
    {
        if ($this->entity->public_end_date != null) {
            return $this->entity->public_end_date;
        }
        elseif ($this->entity->aic_end_at != null) {
            return new Carbon($this->entity->aic_end_at);
        }
        else {
            return "";
        }
    }

    public function itemprops()
    {
        return [
            'description' => $this->entity->short_description,
            'department'  => $this->entity->department_display,
        ];
    }

    public function getHistoryImagesForMediaComponent()
    {
        return $this->entity->historyImages->each(function($image) {
            $image->useArtworkSrcset = true;
            $image->isPublicDomain = true;
        })->toArray();
    }

    public function navigation()
    {
        return array_filter([$this->galleryLink(), $this->waitTime(), $this->relatedEventsLink(), $this->closingSoonLink()]);
    }

    protected function galleryLink()
    {
        $location = $this->entity->exhibition_location ?: $this->entity->gallery_title;
        if ($location) {
            return [
                'label' => $location,
                'iconBefore' => 'location'
            ];
        }
    }

    protected function waitTime()
    {
        // WEB-1854: Only cache these API results for 60 seconds
        $waitTimes = $this->entity->apiModels('waitTimes', 'WaitTime', 60);

        if (!$waitTimes) {
            return [];
        }

        $waitTime = $waitTimes->first();

        $label = '';

        if ($waitTime) {
            $label = 'Current wait time: ' . $waitTime->present()->display();
        }

        if ($this->entity->wait_time_override) {
            if ($label) {
                $label .= '<br/>';
            }

            $label .= $this->entity->wait_time_override;
        }

        if ($label) {
            return [
                'label' => $label,
                'iconBefore' => 'clock',
                'variation' => 'm-link-list__trigger--wait-time',
            ];
        }

        return [];
    }

    protected function relatedEventsLink()
    {
        $count = $this->entity->eventsCount();

        if ($count > 0) {
            return [
                'label' =>  $count . ' related ' . Str::plural('event', $count),
                'href' => '#related_events',
                'iconBefore' => 'calendar'
            ];
        }
    }

    protected function closingSoonLink()
    {
        if ($this->entity->isOngoing) {
           return [
                'label' => 'Ongoing',
                'variation' => 'ongoing'
            ];
        } else if($this->entity->isClosed) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else if($this->entity->isNowOpen) {
             return [
                'label' => 'Now Open',
                'variation' => 'ongoing'
            ];
        } else if($this->entity->isClosingSoon) {
             return [
                'label' => 'Closing Soon',
                'variation' => 'closing-soon'
            ];
        } else if($this->entity->exclusive) {
            return [
                'label' => 'Member Exclusive',
                'variation' => 'ongoing'
            ];
        }
    }

    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    public function addInjectAttributes($variation = null)
    {
        if ((
            date('w') != 2 && date('w') != 3 && date('H') >= 10 && date('H') < 18
        ) && (
            Carbon::now()->between($this->entity->dateStart, $this->dateEnd)
        )){
            $injectUrl = route('exhibitions.waitTime', [
                'id' => $this->entity->id,
                'slug' => $this->entity->getSlug(),
                'variation' => $variation,
            ]);

            return 'class="o-injected-container" data-behavior="injectContent" data-injectContent-url="' . $injectUrl . '"';
        }
    }
}

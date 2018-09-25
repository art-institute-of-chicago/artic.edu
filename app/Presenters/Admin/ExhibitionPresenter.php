<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

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

    // For exhibition listings. Pass to _m-article-header..?
    public function formattedDate()
    {
        $date = '';
        $date_format = false;

        if (!empty($this->entity->dateStart)) {
            $year_start = $this->entity->dateStart->format("Y");
            if (!empty($this->entity->dateEnd)) {
             $year_end = $this->entity->dateEnd->format("Y");
             if($year_start == $year_end) {
                $date_format = true;
             }
            }

            if($date_format == true) {
                $date .= '<time datetime="'.$this->entity->dateStart->format("Y-m-d").'" itemprop="startDate">'.$this->entity->dateStart->format('M j').'</time>';
            } else {
                $date .= '<time datetime="'.$this->entity->dateStart->format("Y-m-d").'" itemprop="startDate">'.$this->entity->dateStart->format('M j, Y').'</time>';
            }

        }
        if (!empty($this->entity->dateEnd)) {
            $date .= '&ndash;<time datetime="'.$this->entity->dateEnd->format("Y-m-d").'" itemprop="endDate">'.$this->entity->dateEnd->format('M j, Y').'</time>';
        }

        return $date;
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

    public function navigation()
    {
        return array_filter([$this->galleryLink(), $this->relatedEventsLink(), $this->closingSoonLink()]);
    }

    public function itemprops() {
        return [
            'description' => $this->entity->short_description,
            'department'  => $this->entity->department_display,
        ];
    }

    protected function galleryLink() {
        if ($this->entity->gallery_title) {
            return [
                'label' => $this->entity->gallery_title,
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

    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }
}

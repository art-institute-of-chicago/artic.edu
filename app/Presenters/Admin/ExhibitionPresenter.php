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

        return $start->format('m d Y') . '–' . $end->format('m d Y');
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

    public function itemprops() {
        return [
            'description' => $this->entity->short_description,
            'department'  => $this->entity->department_display,
        ];
    }

    protected function galleryLink() {
        if ($this->entity->gallery_id) {
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
        if ($this->entity->status == 'Closed') {
            return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else {
            if ($this->entity->closingSoon) {
                return [
                    'label' => 'Closing Soon',
                    'variation' => 'closing-soon'
                ];
            }
        }
    }

    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }
}

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
     
        $date = "";
        $hasStart = false;
        $start = $this->entity->asDateTime($this->aic_start_at);
        $end = "";


        if($this->aic_start_at == null) {
        } else {
            $start = $this->entity->asDateTime($this->aic_start_at);
            $date = $start->format('m d Y');
            $hasStart = true;

 
        }

        if($this->aic_end_at == null){
        } else {
            $end   = $this->entity->asDateTime($this->aic_end_at);
            if($hasStart) {
                $date .=  ' - ' . $end->format('m d Y');
            }
        }



        if(empty($this->aic_end_at)) {
            if($start->format("Y") > 2010) {
             $this->entity->status = "Ongoing";
            } else if($start->format("Y") < 2010) {
             $this->entity->status = "Closed";
            }

        }

        if(empty($this->aic_start_at)) {
            $this->entity->status = "Closed";
        }

         if(empty($this->aic_start_at) && empty($this->aic_end_at) ) {
            $this->entity->status = "Closed";
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

        if (!empty($this->entity->dateStart)) {
            $date .= '<time datetime="'.$this->entity->dateStart->format("Y-m-d").'" itemprop="startDate">'.$this->entity->dateStart->format('M j, Y').'</time>';
        }
        if (!empty($this->entity->dateEnd)) {
            $date .= '&ndash;  <time datetime="'.$this->entity->dateEnd->format("Y-m-d").'" itemprop="endDate">'.$this->entity->dateEnd->format('M j, Y').'</time>';
        }

        return $date;
    }

    public function startAt()
    {
        if($this->entity->aic_start_at != null) {
            return new Carbon($this->entity->aic_start_at);

        } else {
            return "";
        }
    }

    public function endAt()
    {
        if($this->entity->aic_end_at != null) {
            return new Carbon($this->entity->aic_end_at);
        }  else {
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
        if (empty($this->entity->dateEnd) && $this->entity->dateStart->format('Y') > 2010) {
           return [
                'label' => 'Ongoing',
                'variation' => 'ongoing'
            ];
        } else if(empty($this->entity->dateEnd) && $this->entity->dateStart->format('Y') < 2010) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else if(empty($this->entity->dateStart)) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else if(empty($this->entity->dateStart) && empty($this->entity->dateEnd)) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        } else if($this->entity->dateEnd < Carbon::now()) {
             return [
                'label' => 'Closed',
                'variation' => 'closing-soon'
            ];
        }
         else {
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

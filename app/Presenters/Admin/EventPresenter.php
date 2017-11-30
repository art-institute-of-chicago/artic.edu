<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class EventPresenter extends BasePresenter
{

    // public function publish_start_date()
    // {
    //     if ($this->entity->publish_start_date)
    //         return $this->entity->publish_start_date->format("m/d/Y H:i");
    // }

    // public function publish_end_date()
    // {
    //     if ($this->entity->publish_end_date)
    //         return $this->entity->publish_end_date->format("m/d/Y H:i");
    // }

    // public function artists()
    // {

    //     $string = "";
    //     foreach($this->entity->artists as $artist) {
    //         $string .= (!empty($string) ? ", " : "") .  $artist->present()->name;
    //     }

    //     return $string;
    // }

    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    // public function type()
    // {
    //     switch($this->entity->type)
    //     {
    //         case $this->entity::SoloExhibitionType  : $type = "Solo Exhibition"; break;
    //         case $this->entity::GroupExhibitionType : $type = "Group Exhibition"; break;
    //         case $this->entity::ArtFairExhibitionType : $type = "Art Fair"; break;
    //     }

    //     return $type;
    // }

    // public function artworks()
    // {
    //     $subRoute = "soloExhibitions";
    //     switch($this->entity->type)
    //     {
    //         case $this->entity::SoloExhibitionType  : $subRoute = "soloExhibitions"; break;
    //         case $this->entity::GroupExhibitionType : $subRoute = "groupExhibitions"; break;
    //         case $this->entity::ArtFairExhibitionType : $subRoute = "artFairs"; break;
    //     }

    //     $url = route("admin.resources.Exhibitions.{$subRoute}.edit-artworks",[$this->entity->id]);
    //     $nbArtworks = count($this->entity->artworks);
    //     $label = $nbArtworks > 0 ? "Select artworks: ({$nbArtworks})" : "Select artworks";

    //     return "<a href='".$url."'>{$label}</a>";
    // }

    // public function titleBrowser()
    // {
    //     $title = "";
    //     switch($this->entity->type) {
    //         case $this->entity::SoloExhibitionType:
    //             $title = $this->artist();
    //         break;

    //         case $this->entity::GroupExhibitionType:
    //             if ( !$this->entity->title || empty($this->entity->title)){
    //                 $title = "Group Exhibition";
    //             } else {
    //                 $title = $this->entity->title;
    //             }
    //             break;

    //         case $this->entity::ArtFairExhibitionType:
    //             $title = $this->entity->title . (!empty($this->entity->location) ? ", ".$this->entity->location : "");
    //             break;
    //     }

    //     return $title;
    // }

    // public function artist()
    // {
    //     if ( count($this->entity->artists) > 0)
    //         return $this->entity->artists->first()->name;

    //     return 'sans nom';
    // }

}

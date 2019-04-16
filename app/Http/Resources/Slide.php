<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Slide extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (get_class($this->resource) === 'App\Models\Experience') {
            $return = [];
        } else {

        }
        return [
            'id' => $this->id,
            'type' => $this->asset_type,
            'title' => $this->title,
            'headline' => $this->headline,
        ];
    }

    public function commonStructure()
    {

    }
}

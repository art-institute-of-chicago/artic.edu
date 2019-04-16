<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideMedia extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'src' => '',
            'credits' => [
                'creditsACP' => 'Girard Thibault (Flemish, died ca. 1629)',
                'creditsTitle' => 'Academie de lespee',
                'creditsDate' => '1627',
                'creditsMedium' => 'Illustrated book',
                'creditsDimensions' => '',
                'creditsCreditLine' => '',
                'creditsRefNum' => '',
                'creditsCopyright' => '',
                'type' => 'manual',
            ],
            'altText' => '',
        ];
    }
}

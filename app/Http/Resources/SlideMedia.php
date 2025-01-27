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
            'src' => $this->image('experience_image'),
            '__option_credits' => $this->inline_credits === 'on',
            'caption' => $this->caption,
            'credits' => [
                'image_credits' => $this->image_credits,
            ],
            'altText' => $this->imageAltText('experience_image'),
        ];
    }
}

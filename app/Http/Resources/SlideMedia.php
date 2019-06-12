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
            'credits' => [
                'creditsACP' => $this->artist,
                'creditsTitle' => $this->credit_title,
                'creditsDate' => $this->credit_date,
                'creditsMedium' => $this->medium,
                'creditsDimensions' => $this->dimensions,
                'creditsCreditLine' => $this->credit_line,
                'creditsRefNum' => $this->main_reference_number,
                'creditsCopyright' => $this->copyright_notice,
                'type' => $this->credits_input,
            ],
            'altText' => $this->imageAltText('experience_image'),
        ];
    }

    // protected function getImageSrc($url)
    // {
    //     $matched = preg_match('/(?<=https:\/\/' . env('IMGIX_SOURCE_HOST', 'artic-web.imgix.net') . '\/).+(?=\?)/', $url, $matches);
    //     if ($matched) {
    //         return $matches[0];
    //     }
    //     return '';
    // }
}

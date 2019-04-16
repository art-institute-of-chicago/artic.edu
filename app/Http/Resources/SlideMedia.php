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
            'src' => $this->getImageSrc($this->image('experience_image')),
            'credits' => [
                'creditsACP' => $this->artist,
                'creditsTitle' => $this->credit_title,
                'creditsDate' => $this->credit_date,
                'creditsMedium' => $this->medium,
                'creditsDimensions' => $this->dimensions,
                'creditsCreditLine' => $this->credit_line,
                'creditsRefNum' => $this->main_refernece_number,
                'creditsCopyright' => $this->copyright_notice,
                'type' => $this->credits_input,
            ],
            'altText' => $this->alt_text,
        ];
    }

    protected function getImageSrc($url)
    {
        $matched = preg_match('/(?<=https:\/\/artic-web.imgix.net\/).+(?=\?)/', $url, $matches);
        if ($matched) {
            return $matches[0];
        }
        return '';
    }
}

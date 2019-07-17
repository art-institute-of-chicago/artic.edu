<?php

namespace App\Http\Resources;

use App\Models\SeamlessImage;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideAsset extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->media_type === 'type_image') {
            $image = $this->seamlessExperienceImage->first();
            return [
                'type' => 'image',
                'title' => $this->media_title,
                'id' => $image->imageObject('experience_image') ? $image->imageObject('experience_image')->id : '0',
                'width' => $image->imageObject('experience_image')->width,
                'height' => $image->imageObject('experience_image')->height,
                'src' => [$image->image('experience_image')],
            ];
        } elseif ($this->fileObject('sequence_file')) {
            $images = SeamlessImage::where('zip_file_id', $this->fileObject('sequence_file')->id)->get();
            $src = $images->map(function ($image) {
                return [
                    'src' => 'https://' . config('twill.imgix_source_host') . '/seq/' . $image->file_name,
                    'frame' => $image->frame,
                ];
            })->toArray();
            return [
                'type' => 'sequence',
                'title' => $this->media_title,
                'id' => $this->seamless_asset ? (string) $this->seamless_asset['assetId'] : "0",
                'width' => $images->first() ? $images->first()->width : 0,
                'height' => $images->first() ? $images->first()->height : 0,
                'src' => $src,
            ];
        } else {
            return [];
        }
    }
}

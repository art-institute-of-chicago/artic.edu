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
        $seamless_file = $this->fileObject('sequence_file');

        if ($seamless_file) {
            $images = SeamlessImage::where('zip_file_id', $seamless_file->id)->get();
            $src = $images->map(function ($image) {
                return [
                    'src' => 'https://' . env('IMGIX_SOURCE_HOST') . '/seq/' . $image->file_name,
                    'frame' => $image->frame,
                ];
            })->toArray();
        } else {
            $src = [];
        }

        return [
            'type' => $this->media_type === 'type_image' ? 'image' : 'sequence',
            'title' => $this->media_title,
            'id' => $this->id,
            'width' => 100,
            'height' => 213,
            'src' => $src,
        ];
    }
}

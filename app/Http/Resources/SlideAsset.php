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
                    'src' => 'https://' . env('IMGIX_SOURCE_HOST', 'artic-web.imgix.net') . '/seq/' . $image->file_name,
                    'frame' => $image->frame,
                ];
            })->toArray();
            return [
                'type' => $this->media_type === 'type_image' ? 'image' : 'sequence',
                'title' => $this->media_title,
                'id' => $this->seamless_asset ? (string) $this->seamless_asset['assetId'] : "0",
                'width' => $images->first()->width,
                'height' => $images->first()->height,
                'src' => $src,
            ];
        } else {
            return [
                'type' => $this->media_type === 'type_image' ? 'image' : 'sequence',
                'title' => $this->media_title,
                'id' => $this->seamless_asset ? (string) $this->seamless_asset['assetId'] : "0",
            ];
        }
    }
}

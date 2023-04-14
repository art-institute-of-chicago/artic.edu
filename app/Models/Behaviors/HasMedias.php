<?php

namespace App\Models\Behaviors;

use A17\Twill\Models\Behaviors\HasMedias as BaseHasMedias;

trait HasMedias
{
    use BaseHasMedias {
        BaseHasMedias::imageAsArray as parentImageAsArray;
    }

    public function imageAsArray($role, $crop = 'default', $params = [], $media = null)
    {
        if (!$media) {
            $media = $this->medias->first(function ($media) use ($role, $crop) {
                return $media->pivot->role === $role && $media->pivot->crop === $crop;
            });
        }

        if ($media) {
            return [
                'src' => $this->image($role, $crop, $params, false, false, $media),
                'width' => $media->pivot->crop_w ?? $media->width,
                'height' => $media->pivot->crop_h ?? $media->height,
                'crop_x' => $media->pivot->crop_x ?? 0,
                'crop_y' => $media->pivot->crop_y ?? 0,
                'alt' => $this->imageAltText($role, $media),
                'caption' => $this->imageCaption($role, $media),
                'video' => $this->imageVideo($role, $media),
                'restrict' => $media->tags->contains('slug', 'restrict-download') ?? false,
            ];
        }

        return $this->parentImageAsArray($role, $crop, $params, $media);
    }
}

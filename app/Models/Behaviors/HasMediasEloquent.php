<?php

namespace App\Models\Behaviors;

trait HasMediasEloquent
{
    /**
     * Implement image helpers to avoid overwriting the Twill ones.
     * If it has an image, run it through aic_convertFromImage
     */
    public function imageFront(...$parameters)
    {
        $imageObject = $this->imageObject(...$parameters);

        if (!$imageObject) {
            return;
        }

        return $this->convertImageFront($imageObject);
    }

    public function imagesFront(...$parameters)
    {
        $imageObjects = $this->imageObjects(...$parameters);

        if ($imageObjects->count() < 1) {
            return;
        }

        return $imageObjects->map(function($imageObject) {
            return $this->convertImageFront($imageObject);
        });
    }

    private function convertImageFront($imageObject)
    {
        return aic_convertFromImage($imageObject, [
            'crop_x' => $imageObject->pivot->crop_x,
            'crop_y' => $imageObject->pivot->crop_y,
            'crop_w' => $imageObject->pivot->crop_w,
            'crop_h' => $imageObject->pivot->crop_h
        ]);
    }
}

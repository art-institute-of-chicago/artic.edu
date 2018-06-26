<?php

namespace App\Models\Behaviors;

use Illuminate\Support\Facades\App;
use LakeviewImageService;

trait HasMediasApi
{

    // You have to define roles and crop on the API model.
    //
    // 'field': Optional, API field with the image ID (if not defined, default to image_id)
    // 'width', 'height': Optional, cropping options
    //
    // public $mediasParams
    //     'hero' => [
    //         'default' => [
    //             'field'  => 'image_id',   // Optional
    //             'width'  => 45,           // Optional
    //             'height' => 45            // Optional
    //         ],
    //     ],
    // ];

    public function imageFront($role = 'hero', $crop = null)
    {
        if (empty($this->mediasParams)) {
            throw new \Exception('You have to define $mediasParams when using imageFront');
        }

        if (isset($this->mediasParams[$role])) {
            if ($crop && !empty($this->{$this->getImageField($role, $crop)})) {
                $image = LakeviewImageService::getImage($this, $this->getImageField($role, $crop));
                $image['width'] = $this->getWidth($role, $crop, $image);
                $image['height'] = $this->getHeight($role, $crop, $image);
                $image['alt'] = $this->image_alt_text;

                return $image;
            } else {
                if (!empty($this->{$this->getImageField($role, 'default')})) {
                    return LakeviewImageService::getImage($this, $this->getImageField($role, 'default'));
                }
            }
        }

        // If nothing has been returned on the API side, check for an augmented model
        if ($this->hasAugmentedModel() && method_exists($this->getAugmentedModel(), 'imageFront')) {
            return $this->getAugmentedModel()->imageFront($role, $crop);
        }
    }

    protected function getImageField($role, $crop)
    {
        if (isset($this->mediasParams[$role][$crop]['field'])) {
            return $this->mediasParams[$role][$crop]['field'];
        } else {
            return 'image_id';
        }
    }

    protected function getWidth($role, $crop, $image)
    {
        if (isset($this->mediasParams[$role][$crop]['width'])) {
            return $this->mediasParams[$role][$crop]['width'];
        } else {
            return isset($image['width']) ? $image['width'] : '';
        }
    }

    protected function getHeight($role, $crop, $image)
    {
        if (isset($this->mediasParams[$role][$crop]['height'])) {
            return $this->mediasParams[$role][$crop]['height'];
        } else {
            return isset($image['height']) ? $image['height'] : '';
        }
    }

}

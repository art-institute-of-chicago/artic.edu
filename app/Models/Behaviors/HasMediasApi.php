<?php

namespace App\Models\Behaviors;

use DamsImageService;

trait HasMediasApi
{
    /**
     * You have to define roles and crop on the API model.
     *
     * 'field': Optional, API field with the image ID (if not defined, default to image_id)
     * 'width', 'height': Optional, cropping options
     *
     * public $mediasParams
     *     'hero' => [
     *         'default' => [
     *             'field'  => 'image_id',   // Optional
     *             'width'  => 45,           // Optional
     *             'height' => 45            // Optional
     *         ],
     *     ],
     * ];
     */
    public function imageFront($role = 'hero', $crop = null)
    {
        if (empty($this->mediasParams)) {
            throw new \Exception('You have to define $mediasParams when using imageFront');
        }

        if (isset($this->mediasParams[$role])) {
            if ($crop && !empty($this->{$this->getImageField($role, $crop)})) {
                $image = DamsImageService::getImage($this, $this->getImageField($role, $crop));
                $image['width'] = $this->getWidth($role, $crop, $image);
                $image['height'] = $this->getHeight($role, $crop, $image);

                return $image;
            }

            if (!empty($this->{$this->getImageField($role, 'default')})) {
                $image = DamsImageService::getImage($this, $this->getImageField($role, 'default'));

                return $image;
            }
        }

        // If nothing has been returned on the API side, check for an augmented model
        if ($this->hasAugmentedModel() && $this->getAugmentedModel() && method_exists($this->getAugmentedModel(), 'imageFront')) {
            return $this->getAugmentedModel()->imageFront($role, $crop);
        }
    }

    public function defaultCmsImage($params = [])
    {
        $image = DamsImageService::getImage($this, 'image_id', 100, 100);

        if ($image) {
            return $image['src'];
        }

        return ImageService::getTransparentFallbackUrl($params);
    }

    protected function getImageField($role, $crop)
    {
        if (isset($this->mediasParams[$role][$crop]['field'])) {
            return $this->mediasParams[$role][$crop]['field'];
        }

        return 'image_id';
    }

    protected function getWidth($role, $crop, $image)
    {
        if (isset($this->mediasParams[$role][$crop]['width'])) {
            return $this->mediasParams[$role][$crop]['width'];
        }

        return $image['width'] ?? '';
    }

    protected function getHeight($role, $crop, $image)
    {
        if (isset($this->mediasParams[$role][$crop]['height'])) {
            return $this->mediasParams[$role][$crop]['height'];
        }

        return $image['height'] ?? '';
    }
}

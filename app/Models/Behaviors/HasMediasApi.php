<?php

namespace App\Models\Behaviors;

use DamsImageService;

trait HasMediasApi
{
    /**
     * Replaces `imageFront()`. This more closely resembles Twill 3's
     * `HasMedias::image()` method, see:
     * https://twillcms.com/docs/api/3.x/A17/Twill/Models/Behaviors/HasMedias.html#method_image
     *
     * Define $mediasParams as they are defined in the Twill documentation:
     * https://twillcms.com/docs/form-fields/medias.html#content-example
     *
     * An additional `field` key may be defined for a crop that specifies the field
     * on the API record that contains the image ID. The default is `image_id`.
     *
     * Example:
     *  public $mediasParams = [
     *      'iiif' => [
     *          'default' => [
     *              [
     *                  'name' => 'default',
     *                  'field' => 'image_id',
     *                  'height' => 800,
     *                  'width' => 800,
     *              ]
     *          ]
     *      ]
     *  ];
     */
    public function image($role, $crop = 'default', $params = [])
    {
        $cropParams = $this->getMediasParams()[$role][$crop][0];
        $imageField = $cropParams['field'] ?? 'image_id';
        return DamsImageService::getUrl($this->{$imageField}, $cropParams + $params);
    }

    /**
     * DEPRECATED
     *
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

    public function cmsImage($role, $crop = 'default', $params = [])
    {
        $image = DamsImageService::getImage($this, $this->getImageField($role, $crop), $params['w'], $params['h']);

        if ($image) {
            return $image['src'];
        }

        return ImageService::getTransparentFallbackUrl($params);
    }

    public function defaultCmsImage($params = [])
    {
        return $this->cmsImage('iiif', 'default', ['w' => 100, 'h' => 100]);
    }

    public function getMediasParams(): array
    {
        return (isset($this->mediasParams) && is_array($this->mediasParams))
            ? $this->mediasParams
            : config('twill.default_crops');
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

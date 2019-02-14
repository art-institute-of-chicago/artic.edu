<?php

namespace App\Libraries;

use A17\Twill\Services\MediaLibrary\ImageServiceDefaults;
use A17\Twill\Services\MediaLibrary\ImageServiceInterface;
use Cache;

class LakeviewImageService implements ImageServiceInterface
{
    use ImageServiceDefaults;

    protected $base_url;
    protected $version;

    protected $cacheVersion = "1";

    public function __construct()
    {
        $this->base_url = config('lakeview.cdn_enabled') ? config('lakeview.base_url_cdn') : config('lakeview.base_url');
        $this->version = config('lakeview.version');
    }

    public function getBaseUrl()
    {
        return $this->base_url;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getImage($object, $imageField = 'image_id', $width = '', $height = '')
    {
        $credit = null;
        $creditUrl = null;
        $shareTitle = null;
        $downloadName = str_replace('.', '', $object->title);

        $preLoadedInfo = $this->getInfo($object, $imageField);

        $src = $this->getUrl($object->$imageField, ['width' => $width, 'height' => $height]);
        $srcset = $this->getUrl($object->$imageField, ['width' => $width, 'height' => $height]) . " 300w";

        $image = array(
            "type" => 'lakeview',
            "src" => $src,
            "srcset" => $srcset,
            "width" => $preLoadedInfo['width'],
            "height" => $preLoadedInfo['height'],
            "shareUrl" => '#',
            "shareTitle" => $shareTitle,
            "downloadUrl" => $src,
            "downloadName" => $downloadName,
            "credit" => $credit,
            "creditUrl" => $creditUrl,
            "iiifId" => $this->base_url . $this->version . '/' . $object->$imageField,
        );

        if (isset($preLoadedInfo['lqip']) && !empty($preLoadedInfo['lqip'])) {
            $image['lqip'] = $preLoadedInfo['lqip'];
        }

        if (isset($preLoadedInfo['alt']) && !empty($preLoadedInfo['alt'])) {
            $image['alt'] = $preLoadedInfo['alt'];
        }

        return $image;
    }

    public function getUrl($id, array $params = [])
    {
        $width = isset($params['width']) ? $params['width'] : '';
        $height = isset($params['height']) ? $params['height'] : '';
        $size = isset($params['size']) ? $params['size'] : 'full';

        $dimensions = '!3000,3000';
        if ($width != '' || $height != '') {
            $dimensions = $width . ',' . $height;
        }

        return $this->base_url . $this->version . '/' . $id . '/' . $size . '/' . $dimensions . '/0/default.jpg';
    }

    public function getUrlWithCrop($id, array $cropParams, array $params = [])
    {
    }

    public function getUrlWithFocalCrop($id, array $cropParams, $width, $height, array $params = [])
    {
    }

    public function getLQIPUrl($id, array $params = [])
    {
    }

    public function getSocialUrl($id, array $params = [])
    {
    }

    public function getCmsUrl($id, array $params = [])
    {
    }

    public function getRawUrl($id)
    {
    }

    public function getInfo($object, $imageField = 'image_id')
    {
        $info = [];

        // Try returning already loaded information
        if (!empty($object->thumbnail)) {
            if ($object->thumbnail->width && $object->thumbnail->height) {
                $info['width']  = $object->thumbnail->width;
                $info['height'] = $object->thumbnail->height;
            } else {
                $info = array_merge($info, $this->getDimensions($object->$imageField));
            }

            if ($object->thumbnail->lqip) {
                $info['lqip'] = $object->thumbnail->lqip;
            }

            if ($object->thumbnail->alt_text) {
                $info['alt']  = $object->thumbnail->alt_text;
            }

            return $info;
        } else {
            // Hit the server to get the info if not available
            return $this->getDimensions($object->$imageField);
        }
    }

    public function getDimensions($id)
    {
        try {
            $imageMetadata = $this->fetchImageInfo($id);

            return [
                'width' => $imageMetadata->width,
                'height' => $imageMetadata->height,
            ];
        } catch (\Exception $e) {
            return [
                'width' => 0,
                'height' => 0,
            ];
        }
    }

    protected function getCrop($crop_params)
    {
    }

    protected function getFocalPointCrop($crop_params, $width, $height)
    {
    }

    protected function fetchImageInfo($id)
    {
        $json = Cache::remember('lakeview-image-' . $id . $this->cacheVersion, 24 * 60, function () use ($id) {
            try {
                return json_decode(@file_get_contents($this->base_url . $this->version . '/' . $id . '/info.json'));
            } catch (Exception $e) {
                return [];
            }
        });
        return $json;
    }
}

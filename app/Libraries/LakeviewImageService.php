<?php

namespace App\Libraries;

use A17\CmsToolkit\Services\MediaLibrary\ImageServiceInterface;
use A17\CmsToolkit\Services\MediaLibrary\ImageServiceDefaults;

use Cache;

class LakeviewImageService implements ImageServiceInterface
{
    use ImageServiceDefaults;

    protected $base_url = "https://lakeimagesweb.artic.edu/iiif/";
    protected $version = "2";
    protected $cacheVersion = "1";

    public function __construct()
    {
    }

    public function getImage($image_id, $width = '', $height = '') {
        $credit = null;
        $creditUrl = null;
        $shareTitle = null;
        $downloadName = null;

        $dimensions = $this->getDimensions($image_id);

        $src = $this->getUrl($image_id, ['width' => $width, 'height' => $height]);
        $srcset = $this->getUrl($image_id, ['width' => $width, 'height' => $height])." 300w";
        $image = array(
            "type" => 'lakeview',
            "src" => $src,
            "srcset" => $srcset,
            "width" => $dimensions['width'],
            "height" => $dimensions['height'],
            "shareUrl" => '#',
            "shareTitle" => $shareTitle,
            "downloadUrl" => $src,
            "downloadName" => $downloadName,
            "credit" => $credit,
            "creditUrl" => $creditUrl,
        );

        return $image;
    }

    public function getUrl($id, array $params = [])
    {
        $width = isset($params['width']) ? $params['width'] : '';
        $height = isset($params['height']) ? $params['height'] : '';
        $size = isset($params['size']) ? $params['size'] : 'full';

        $data = $this->fetchImageInfo($id);

        $dimensions = 'full';
        if ($width != '' || $height != '') {
            $dimensions = $width.','.$height;
        }

        return $this->base_url.$this->version.'/'.$id.'/'.$size.'/'.$dimensions.'/0/default.jpg';
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

    public function getDimensions($id)
    {
        try {
            $imageMetadata = $this->fetchImageInfo($id);

            return [
                'width' => $imageMetadata->width,
                'height' => $imageMetadata->height
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

    protected function fetchImageInfo($id) {
        $json = Cache::remember('lakeview-image-'.$id.$this->cacheVersion, 24*60, function () use ($id) {
            try {
                return json_decode(@file_get_contents($this->base_url.$this->version.'/'.$id.'/info.json'));
            } catch (Exception $e) {
                return [];
            }
        });
        return $json;
    }
}

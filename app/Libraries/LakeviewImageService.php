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

    public function __construct()
    {
    }

      private function getImage($image_id, $width = false, $height = false) {
        //$color = preg_replace('/#/i', '', $this->faker->hexcolor);
        $width = isset($width) && $width ? $width : $this->faker->numberBetween(300,700);
        $height = isset($height) && $height ? $height : $this->faker->numberBetween(300,700);
        //$src = "http://placehold.dev.area17.com/image/".$width."x".$height."/?bg=".$color."&text=";
        $src = "//placeimg.com/".$width."/".$height."/nature";
        //$src = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
        $srcset = "//placeimg.com/".$width."/".$height."/nature ".$width."w";
        //$src = $this->faker->imageUrl($width, $height, 'nature');
        //$src = str_replace('https://', 'http://', $src);

        $credit = $this->faker->boolean() ? $this->faker->sentence(3) : null;
        $creditUrl = ($credit && $this->faker->boolean()) ? '#' : null;

        $image = array(
            "src" => $src,
            "srcset" => $srcset,
            "width" => $width,
            "height" => $height,
            "shareUrl" => '#',
            "shareTitle" => $this->faker->sentence(5),
            "downloadUrl" => $src,
            "downloadName" => $this->faker->word(),
            "credit" => $credit,
            "creditUrl" => $creditUrl,
        );

        return $image;
      }


    public function getUrl($id, array $params = [])
    {
        // dd('abc');
        $width = isset($params['width']) ? $params['width'] : '';
        $height = isset($params['height']) ? $params['height'] : '';
        $size = isset($params['size']) ? $params['size'] : 'full';

        $data = $this->fetchImageInfo($id);
        // dd($data);

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
        $json = Cache::remember('lakeview-image-'.$id, 24*60, function () use ($id) {
            return json_decode(file_get_contents($this->base_url.$this->version.'/'.$id.'/info.json'));
        });
        return $json;
    }
}

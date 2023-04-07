<?php

namespace App\Libraries;

use A17\Twill\Services\MediaLibrary\ImageServiceDefaults;
use A17\Twill\Services\MediaLibrary\ImageServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Helpers\StringHelpers;

class DamsImageService implements ImageServiceInterface
{
    use ImageServiceDefaults;

    protected $base_url;
    protected $version;

    protected $cacheVersion = '1';

    public function __construct()
    {
        $this->base_url = config('dams.cdn_enabled') ? config('dams.base_url_cdn') : config('dams.base_url');
        $this->version = config('dams.version');
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
        $downloadName = $object->main_reference_number . ' - ' . StringHelpers::truncateStr($object->title, 50) . '.jpg';

        $preLoadedInfo = $this->getInfo($object, $imageField);

        $src = $this->getUrl($object->{$imageField}, ['width' => $width, 'height' => $height]);
        $srcset = $this->getUrl($object->{$imageField}, ['width' => $width, 'height' => $height]) . ' 300w';

        $image = [
            'type' => 'dams',
            'src' => $src,
            'srcset' => $srcset,
            'width' => $preLoadedInfo['width'],
            'height' => $preLoadedInfo['height'],
            'shareUrl' => '#',
            'shareTitle' => $shareTitle,
            'downloadUrl' => $src,
            'downloadName' => $downloadName,
            'credit' => $credit,
            'creditUrl' => $creditUrl,
            'iiifId' => $this->base_url . $this->version . '/' . $object->{$imageField},
        ];

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
        $width = $params['width'] ?? '';
        $height = $params['height'] ?? '';
        $size = $params['size'] ?? 'full';

        $dimensions = '!3000,3000';

        if ($width != '' || $height != '') {
            $dimensions = '!' . $width . ',' . $height;
        }

        return $this->base_url . $this->version . '/' . $id . '/' . $size . '/' . $dimensions . '/0/default.jpg';
    }

    public function getUrlWithCrop($id, array $crop_params, array $params = [])
    {
        return $this->getRawUrl($id);
    }

    public function getUrlWithFocalCrop($id, array $cropParams, $width, $height, array $params = [])
    {
        return $this->getRawUrl($id);
    }

    public function getLQIPUrl($id, array $params = [])
    {
        return $this->getRawUrl($id);
    }

    public function getSocialUrl($id, array $params = [])
    {
        return $this->getRawUrl($id);
    }

    public function getCmsUrl($id, array $params = [])
    {
        return $this->getRawUrl($id);
    }

    public function getRawUrl($id)
    {
        return Storage::disk(config('twill.media_library.disk'))->url($id);
    }

    public function getInfo($object, $imageField = 'image_id')
    {
        $info = [];

        // Try returning already loaded information
        if (!empty($object->thumbnail)) {
            if ($object->thumbnail->width && $object->thumbnail->height) {
                $info['width'] = $object->thumbnail->width;
                $info['height'] = $object->thumbnail->height;
            } else {
                $info = array_merge($info, $this->getDimensions($object->{$imageField}));
            }

            if ($object->thumbnail->lqip) {
                $info['lqip'] = $object->thumbnail->lqip;
            }

            if ($object->thumbnail->alt_text) {
                $info['alt'] = $object->thumbnail->alt_text;
            }

            return $info;
        }
        // Hit the server to get the info if not available
        return $this->getDimensions($object->{$imageField});
    }

    public function getDimensions($id)
    {
        $imageMetadata = $this->fetchImageInfo($id);

        return [
            'width' => $imageMetadata->width ?? 0,
            'height' => $imageMetadata->height ?? 0,
        ];
    }

    protected function getCrop($crop_params)
    {
    }

    protected function getFocalPointCrop($crop_params, $width, $height)
    {
    }

    protected function fetchImageInfo($id)
    {
        $json = Cache::remember('dams-image-' . $id . $this->cacheVersion, 24 * 60 * 60, function () use ($id) {
            try {
                // WEB-1883: Use aggresive curl timeouts to prevent gateway timeout
                $url = $this->base_url . $this->version . '/' . $id . '/info.json';

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // WEB-874: If connection or response take longer than 3 seconds, give up
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);

                $contents = curl_exec($ch);

                if (curl_errno($ch)) {
                    throw new \Exception(curl_error($ch));
                }

                curl_close($ch);

                return json_decode($contents);
            } catch (\Exception $e) {
                return null;
            }
        });

        return $json ?? [];
    }
}

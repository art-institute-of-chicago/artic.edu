<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use DamsImageService;

class Image extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/images',
        'resource' => '/api/v1/images/{id}',
        'search' => '/api/v1/images/search'
    ];

    /**
     * Build image array with this entity's data. No need to hit Dams endpoint
     */
    public function imageFront($role = null, $crop = null)
    {
        $dams = new DamsImageService();
        $credit = $this->credit_line;
        $creditUrl = null;
        $shareTitle = empty($this->artwork_titles) ? null : $this->artwork_titles[0];
        $downloadName = null;

        $src = $dams->getUrl($this->id);
        $srcset = $src . ' 300w';

        $image = [
            'type' => 'dams',
            'src' => $src,
            'srcset' => $srcset,
            'width' => $this->width,
            'height' => $this->height,
            'shareUrl' => $src,
            'shareTitle' => $shareTitle,
            'downloadUrl' => $src,
            'downloadName' => $shareTitle,
            'credit' => $credit,
            'creditUrl' => $creditUrl,
            'iiifId' => $dams->getBaseUrl() . $dams->getVersion() . '/' . $this->id,
            'alt' => $this->alt_text
        ];

        if (isset($this->lqip) && !empty($this->lqip)) {
            $image['lqip'] = $this->lqip;
        }

        return $image;
    }
}

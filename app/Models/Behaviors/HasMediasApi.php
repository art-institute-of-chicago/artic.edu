<?php

namespace App\Models\Behaviors;

use Illuminate\Support\Facades\App;
use LakeviewImageService;

trait HasMediasApi
{

    public $mediasParams = [
        'image_id' => [
            'default' => [
                [
                    'width'  => 45,
                    'height' => 45
                ],
            ],
        ],
    ];

    public function imageFront($parameter = 'image_id', $crop = null)
    {
        if (!empty($this->$parameter)) {
            if ($crop) {
                return LakeviewImageService::getImage($this->$parameter, $this->getWidth($parameter, $crop), $this->getHeight($parameter, $crop));
            } else {
                return LakeviewImageService::getImage($this->$parameter);
            }
        } else {
            if ($this->hasAugmentedModel() && method_exists($this->getAugmentedModel(), 'imageFront')) {
                return $this->getAugmentedModel()->imageFront(...$parameters);
            }
        }
    }

    protected function getWidth($parameter, $crop)
    {
        $this->mediasParams[$parameter][$crop]['width'];
    }

    protected function getHeight($parameter, $crop)
    {
        $this->mediasParams[$parameter][$crop]['height'];
    }

}

<?php

namespace App\Http\Controllers\Helpers;

use A17\Twill\Http\Controllers\Front\Helpers\Seo as BaseSeo;

use Illuminate\Support\Str;

class Seo extends BaseSeo
{
    public $noindex = false;

    public $usesImgix = true;

    public function setImage($image, $maxWidth = 1200)
    {
        if (!empty($image)) {
            $settings = aic_imageSettings([
                'image' => $image,
                'settings' => [
                    'srcset' => array($maxWidth),
                    'sizes' => $maxWidth . 'px',
                ],
            ]);

            if ($settings['srcset']) {
                $this->image = Str::before($settings['srcset'], ' ');
                $this->width = $maxWidth;
                $this->height = floor(($maxWidth / $settings['width']) * $settings['height']);
            }
        }
    }
}

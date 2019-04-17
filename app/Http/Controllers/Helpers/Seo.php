<?php

namespace App\Http\Controllers\Helpers;

use A17\Twill\Http\Controllers\Front\Helpers\Seo as BaseSeo;

use Illuminate\Support\Str;

class Seo extends BaseSeo
{

    public function setImage($image)
    {
        if (!empty($image)) {
            $settings = aic_imageSettings([
                'image' => $image,
                'settings' => [
                    'srcset' => array(1200),
                    'sizes' => '1200px',
                ],
            ]);

            if ($settings['srcset']) {
                $this->image = Str::before($settings['srcset'], ' ');
                $this->width = 1200;
                $this->height = floor((1200 / $settings['width']) * $settings['height']);
            }
        }
    }
}

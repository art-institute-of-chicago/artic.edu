<?php

namespace App\Http\Controllers\Helpers;

use A17\Twill\Http\Controllers\Front\Helpers\Seo as BaseSeo;
use Illuminate\Support\Str;

use App\Helpers\ImageHelpers;

class Seo extends BaseSeo
{
    public $noindex = false;

    public $usesImgix = true;

    public $citationTitle;
    public $citationJournalTitle;
    public $citationJournalAbbrev;
    public $citationPublisher;
    public $citationAuthor = [];
    public $citationPublicationDate;
    public $citationOnlineDate;
    public $citationIssue;

    public function setImage($image, $maxWidth = 1200)
    {
        if (!empty($image)) {
            $settings = ImageHelpers::aic_imageSettings([
                'image' => $image,
                'settings' => [
                    'srcset' => [$maxWidth],
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

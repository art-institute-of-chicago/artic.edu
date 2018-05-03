<?php

/***

aic_convertFromImageProxy

Converts an image proxy url to AIC image object format

***/

function aic_convertFromImageProxy($imageUrl, $options = [])
{
    $src = $imageUrl;

    $image = array(
        "sourceType" => $options['sourceType'] ?? 'imgix',
        "src" => $src,
        "width" => $options['width'] ?? '',
        "height" => $options['height'] ?? '',
        "shareUrl" => '#',
        "shareTitle" => '',
        "downloadUrl" => $src,
        "downloadName" => '',
        "credit" => '',
        "creditUrl" => '',
        "lqip" => $lqip ?? null,
        "alt" => $options['alt_text'] ?? null,
        "caption" => $options['caption'] ?? null,
    );

    return $image;
}

/***

aic_convertFromImage

Converts an image service image object to AIC image object format

***/

function aic_convertFromImage($imageObject, $cropParams = [])
{
    $sourceType = 'imgix';

    $src = ImageService::getUrlWithCrop($imageObject->uuid, $cropParams);

    $credit = '';
    $creditUrl = '';

    $image = array(
        "sourceType" => $sourceType,
        "src" => $src,
        "width" =>  $cropParams['crop_w'] ?? $imageObject->width,
        "height" =>  $cropParams['crop_h'] ?? $imageObject->height,
        "shareUrl" => '#',
        "shareTitle" => '',
        "downloadUrl" => $src,
        "downloadName" => $imageObject->filename,
        "credit" => $credit,
        "creditUrl" => $creditUrl,
        "lqip" => $lqip ?? null,
        "alt" => $imageObject->alt_text ?? null,
        "caption" => $imageObject->caption ?? null,
    );

    return $image;
}

/***

aic_imageSizesCSSsettings

Returns an array of CSS settings for the site - see _variable.scss

***/

function aic_imageSizesCSSsettings() {
    $breakpoints = array(
        'xlarge' => '(min-width: 1640px)',
        'large' => '(min-width: 1200px)',
        'medium' => '(min-width: 900px)',
        'small' => '(min-width: 600px)',
        'xsmall' => '',
    );
    $totalCSScolumns = 58; // all breakpoints
    $xlargeMaxSize = 1500; // just xlarge, its not fluid
    $innerGutterCSSColumns = 2; // all breakpoints
    $outerGutterCSScolumns = 3; // all breakpoints

    return array(
        'breakpoints' => $breakpoints,
        'totalCSScolumns' => $totalCSScolumns,
        'xlargeMaxSize' => $xlargeMaxSize,
        'innerGutterCSSColumns' => $innerGutterCSSColumns,
        'outerGutterCSScolumns' => $outerGutterCSScolumns,
    );
}


function aic_determineImageSourceType($src = '') {
    $sourceType = 'imgix';

    if (strrpos($src, 'lakeimagesweb.artic.edu') > 0 or strrpos($src, '/iiif/') > 0) {
        $sourceType = 'lakeview';
    }

    if (strrpos($src, 'artinstituteshop.org') > 0) {
        $sourceType = 'artinstituteshop';
    }

    if (strrpos($src, 'placehold.dev.area17.com') > 0) {
        $sourceType = 'placehold';
    }

    if (strrpos($src, 'imgix.net') > 0) {
        $sourceType = 'imgix';
    }

    return $sourceType;
}

/***

aic_makePosterUrl

Returns an array of CSS settings for the site - see _variable.scss

***/

function aic_makePosterSrc($src = false) {
    $sourceType = 'imgix';
    $posterSrc = '';

    if ($src) {
        $sourceType = aic_determineImageSourceType($src);

        if ($sourceType === 'placeholder') {
            $posterSrc = "//placehold.dev.area17.com/image/150x84";
        }

        if ($sourceType === 'imgix') {
            $base = explode('?', $src)[0].'?';
            $originalSrcParams = array();
            parse_str($src, $originalSrcParams);
            $imgixSettings = array();

            if (!empty($originalSrcParams['rect'])) {
                $imgixSettings['rect'] = $originalSrcParams['rect'];
            }

            $imgixSettings['fit'] = 'crop';
            $imgixSettings['crop'] = 'faces,edges,entropy';
            $imgixSettings['auto'] = 'compress';
            $imgixSettings['fm'] = 'jpg';
            $imgixSettings['q'] = '20';
            $imgixSettings['w'] = '150';
            $imgixSettings['h'] = '84';
            $imgixSettings['q'] = '10';
            $imgixSettings['blur'] = '75';
            $imgixSettingsString = http_build_query($imgixSettings);
            $posterSrc = $base.$imgixSettingsString;
        }

        if ($sourceType === 'lakeview') {
            $base = explode('/full/full/0/default.jpg', $originalSrc)[0];
            $resizeVal = 'full';
            $strposterSrcingSrc = $base."/".$resizeVal."/150,/0/default.jpg";
        }
    }

    return $posterSrc;
}



/***

aic_imageSettings

Outputs a string for the sizes attribute of an image
Outputs a string for the srcset attribute of an image
Outputs a string for the LQIP src of an image

```
    $settings = aic_imageSettings(array(
        'settings' => $settings,
        'image' => $image,
    ));

    $srcset = $imageSettings['srcset'];
    $sizes = $imageSettings['sizes'];
    $src = $imageSettings['src'];
```


***/

function aic_imageSettings($data) {
    $stringSrcset = '';
    $stringSrc = '';
    $stringSizes = '';
    $stringWidth = '';
    $stringHeight = '';

    $settings = $data['settings'];
    $image = $data['image'];

    $srcset = $settings['srcset'] ?? false;
    $sizes = $settings['sizes'] ?? false;
    $lazyload = $settings['lazyload'] ?? true;

    $sourceType = $image['sourceType'] ?? false;
    $originalSrc = $image['src'] ?? false;
    $width = $image['width'] ?? false;
    $height = $image['height'] ?? false;
    $lqip = $image['lqip'] ?? null;

    $ratio = $settings['ratio'] ?? false;
    $ratioW = null;
    $ratioH = null;

    $LQIPDimension = 25;

    if ($originalSrc && !$sourceType) {
        $sourceType = aic_determineImageSourceType($originalSrc);
    }

    // trying to fill image dimensions in if dimensions haven't been set but we do have a srcset and a ratio specified
    if (!$width && !$height && $srcset) {
        $width = array_values($srcset)[0];
        if ($ratio) {
            if ($ratio === "1:1") {
                $height = $width;
            } else if (sizeof(explode(":",$ratio)) === 2) {
                $ratioW = explode(":",$settings['ratio'])[0];
                $ratioH = explode(":",$settings['ratio'])[1];
                $height = round($width * ($ratioH/$ratioW));
            }
        } else if ($sourceType === 'imgix') {
            $height = 'auto';
        }
    }

    // return if not enough datas, fail safe
    if (!$srcset || !$sourceType || !$originalSrc || !$width || !$height) {

        if ($sourceType === 'artinstituteshop') {
            return array(
                'src' => $originalSrc,
                'sizes' => $stringSizes,
                'srcset' => null,
                'width' => null,
                'height' => null,
                'lqip' => $lqip,
            );
        } else {
            return array(
                'srcset' => $stringSrcset,
                'src' => $originalSrc,
                'sizes' => $stringSizes,
                'width' => $stringWidth,
                'height' => $stringHeight,
                'lqip' => $lqip,
            );
        }
    }

    // assign the sizes
    $stringSizes = $settings['sizes'] ?? '';

    // now, based on the source type, generate URLs as needed
    if ($sourceType === 'placeholder') {
        // work out ratio cropping
        if (!empty($settings['ratio'])) {
            if ($settings['ratio'] === "1:1") {
                // square
                if ($height > $width) {
                    $width = $height;
                } else {
                    $height = $width;
                }
            } else if (sizeof(explode(":",$settings['ratio'])) === 2) {
                // some other ratio
                $ratioW = explode(":",$settings['ratio'])[0];
                $ratioH = explode(":",$settings['ratio'])[1];
                $height = round($width * ($ratioH/$ratioW));
            }
        }
        // for place holders its a bit dumb because its not passing through a service
        foreach ($srcset as $size):
            $stringSrcset .= "//placehold.dev.area17.com/image/".$size."x".round(($height/$width) * $size)." ".$size."w, ";
        endforeach;

        $stringSrc = "//placehold.dev.area17.com/image/".$LQIPDimension."x".round(($height/$width) * $LQIPDimension);
    }

    if ($sourceType === 'imgix') {
        $base = explode('?', $originalSrc)[0].'?';
        $originalSrcParams = array();
        parse_str($originalSrc, $originalSrcParams);
        $imgixSettings = array();

        if (!empty($originalSrcParams['rect'])) {
            $imgixSettings['rect'] = $originalSrcParams['rect'];
        }

        // work out ratio cropping
        if (!empty($settings['ratio']) && $width && $height && $height !== 'auto') {
            if ($settings['ratio'] === "1:1") {
                // square
                if ($height > $width) {
                    $width = $height;
                } else {
                    $height = $width;
                }
            } else if (sizeof(explode(":",$settings['ratio'])) === 2) {
                // some other ratio
                $ratioW = explode(":",$settings['ratio'])[0];
                $ratioH = explode(":",$settings['ratio'])[1];
                $height = round($width * ($ratioH/$ratioW));
            }
            // because we're limiting with a dimension, we need to crop
            if(empty($settings['fit'])) {
                $settings['fit'] = 'crop';
            }
            if(empty($settings['crop'])) {
                $settings['crop'] = 'faces,edges,entropy';
            }
        }

        if (empty($settings['auto'])) {
            $imgixSettings['auto'] = 'compress';
        } else {
            $imgixSettings['auto'] = $settings['auto'];
        }

        if (empty($settings['fm'])) {
            $imgixSettings['fm'] = 'jpg';
        } else {
            $imgixSettings['fm'] = $settings['fm'];
        }

        if (empty($settings['q'])) {
            $imgixSettings['q'] = '80';
        } else {
            $imgixSettings['q'] = $settings['q'];
        }

        if(empty($settings['fit'])) {
            $imgixSettings['fit'] = 'crop';
        } else {
            $imgixSettings['fit'] = $settings['fit'];
        }

        if(empty($settings['bg'])) {
        } else {
            $imgixSettings['bg'] = $settings['bg'];
        }

        if(empty($settings['crop'])) {
            $imgixSettings['crop'] = 'faces,edges,entropy';
        } else {
            $imgixSettings['crop'] = $settings['crop'];
        }

        $imgixSettings['w'] = $width;
        $imgixSettings['h'] = $height;

        // generate variants
        foreach ($srcset as $size):
            $imgixSettings['w'] = $size;
            if ($height && $height !== 'auto') {
                $imgixSettings['h'] = round(($height/$width) * $size);
            }
            $imgixSettingsString = http_build_query($imgixSettings);
            $stringSrcset .= $base.$imgixSettingsString." ".$size."w, ";
        endforeach;

        $imgixSettings['w'] = $LQIPDimension;
        if ($height && $height !== 'auto') {
            $imgixSettings['h'] = round(($height/$width) * $LQIPDimension);
        }
        $imgixSettings['q'] = '10';
        //$imgixSettings['blur'] = '75';
        $imgixSettingsString = http_build_query($imgixSettings);

        $stringSrc = $base.$imgixSettingsString;
    }

    if ($sourceType === 'lakeview') {

        // iiif doesn't have many image processing features..
        // http://iiif.io/api/image/2.1/#region
        // /{region}/{size}/{rotation}/{quality}.{format}

        $base = explode('/full/full/0/default.jpg', $originalSrc)[0];
        $resizeVal = 'full';

        // check to see if a ratio is defined
        if (!empty($settings['ratio'])) {
            if ($settings['ratio'] === "1:1") {
                // iiif does have a square region pre-defined
                $resizeVal = 'square';
                if ($height > $width) {
                    $width = $height;
                } else {
                    $height = $width;
                }
            } else if (sizeof(explode(":",$settings['ratio'])) === 2) {
                // some other ratio
                $ratioW = explode(":",$settings['ratio'])[0];
                $ratioH = explode(":",$settings['ratio'])[1];
                $height = round($width * ($ratioH/$ratioW));
                // need to manually calc area to grab..
                // first check the image is taller than the ratio height we need
                $ratioHeight = round($width * ($ratioH/$ratioW));
                if ($height === $ratioHeight) {
                    // the source image *is* 16:9
                    $resizeVal = 'full';
                } else if ($height > $ratioHeight) {
                    // the source image is 16:something-taller-than-9
                    $cropWidth = $width;
                    $cropHeight = round($cropWidth * ($ratioH/$ratioW));
                    $topPosition = round(($height - $cropHeight) / 2);
                    $resizeVal = "0,".$topPosition.",".$cropWidth.",".$cropHeight;
                    $height = $cropHeight;
                } else {
                    // the source image is 16:something-less-than-9
                    $cropHeight = $height;
                    $cropWidth = round($cropHeight * ($ratioW/$ratioH));
                    $leftPosition = round(($width - $cropWidth) / 2);
                    $resizeVal = $leftPosition.",0,".$cropWidth.",".$cropHeight;
                    $width = $cropWidth;
                }
            }
        }

        // generate variants
        foreach ($srcset as $size):
            $stringSrcset .= $base."/".$resizeVal."/".$size.",/0/default.jpg ".$size."w, ";
        endforeach;
        $stringSrc = $base."/".$resizeVal."/".$LQIPDimension.",/0/default.jpg";
    }

    $stringWidth = $width;
    $stringHeight = $height;

    return array(
        'srcset' => $stringSrcset,
        'src' => $stringSrc,
        'sizes' => $stringSizes,
        'width' => $stringWidth,
        'height' => $stringHeight,
        'lazyload' => $lazyload,
        'lqip' => $lqip,
    );
}


/***

aic_imageSizes

Outputs a string for the sizes attribute of an image

```
    @slot('imageSizes', aic_imageSizes(
      array(
          'xsmall' => '58',
          'small' => '28',
          'medium' => '18',
          'large' => '13',
          'xlarge' => '13',
      )
    ))
```

You can specify set values in units also:

```
    @slot('imageSizes', aic_imageSizes(
      array(
          'xsmall' => '216px',
          'small' => '216px',
          'medium' => '30vw',
          'large' => '18',
          'xlarge' => '18',
      )
    ))
```

Unitless numbers are CSS columns where 1 CSS column is 1/58th the full column width.

Numbers with units get used as is.


* Breakpoints are fluid except xlarge
* For all breakpoints, except xlarge, 1 CSS column is 100vw/64 (64 is 58 + 3 + 3)
* At xlarge, 1 CSS column is 1500px/58

See _grid.scss, @function colspan {}

***/

function aic_imageSizes($data) {
    $sizes = '';
    // grab settings
    $settings = aic_imageSizesCSSsettings();
    // make friendly
    $breakpoints = $settings['breakpoints'];
    $xlargeMaxSize = $settings['xlargeMaxSize'];
    $totalCSScolumns = $settings['totalCSScolumns'];
    $outerGutterCSScolumns = $settings['outerGutterCSScolumns'];
    //
    foreach ($breakpoints as $name => $point):
        if (array_key_exists($name, $data)) {
            if (strrpos($data[$name], 'px') > 0 || strrpos($data[$name], 'vw') > 0) {
                $thisSize = $data[$name];
            } else if ($name === 'xlarge') {
                $thisSize = round($data[$name] * ($xlargeMaxSize/$totalCSScolumns)).'px';
            } else {
                $thisSize = round(($data[$name] * (100/($totalCSScolumns + $outerGutterCSScolumns + $outerGutterCSScolumns))), 2).'vw';
            }
        } else {
            if ($name === 'xlarge') {
                $thisSize = $xlargeMaxSize.'px';
            } else {
                $thisSize = round(($totalCSScolumns * (100/($totalCSScolumns + $outerGutterCSScolumns + $outerGutterCSScolumns))), 2).'vw';
            }
        }
        $sizes .= ($name === 'xlarge' ? '' : ', '). $point .' '. $thisSize;
    endforeach;

    return $sizes;
}

/***

aic_gridListingImageSizes

Outputs a string for the sizes attribute of an image, in a grid listing.

The numbers are how many columns in the grid listing. So in this example, at `small` the items are in a 2 column grid:
_________
| x | x |
| x | x |
| x | x |
---------

And at `medium` they're in a 3 column grid:
_____________
| x | x | x |
| x | x | x |
-------------

```
    @slot('imageSizes', aic_gridListingImageSizes(
      array(
          'xsmall' => '1',
          'small' => '2',
          'medium' => '3',
          'large' => '4',
          'xlarge' => '4',
      )
    ))
```

***/

function aic_gridListingImageSizes($data) {
    $newData = array();
    // grab settings
    $settings = aic_imageSizesCSSsettings();
    // make friendly
    $breakpoints = $settings['breakpoints'];
    $totalCSScolumns = $settings['totalCSScolumns'];
    $innerGutterCSSColumns = $settings['innerGutterCSSColumns'];

    foreach ($breakpoints as $name => $point):
        if (array_key_exists($name, $data)) {
            $newData[$name] = ($totalCSScolumns - (($data[$name] - 1) * $innerGutterCSSColumns)) / $data[$name];
        } else {
            $newData[$name] = 58;
        }
    endforeach;

    $sizes = aic_imageSizes($newData);

    return $sizes;
}

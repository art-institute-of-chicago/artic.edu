<?php

/***

aic_imageSizesCSSsettings

Returns an array of CSS settings for the site - see _variable.scss

***/

function aic_imageSizesCSSsettings() {
    $breakpoints = array(
        'xsmall' => '',
        'small' => '(min-width: 600px)',
        'medium' => '(min-width: 900px)',
        'large' => '(min-width: 1200px)',
        'xlarge' => '(min-width: 1640px)',
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

    $sourceType = $image['sourceType'] ?? false;
    $originalSrc = $image['src'] ?? false;
    $width = $image['width'] ?? false;
    $height = $image['height'] ?? false;

    $LQIPDimension = 25;

    // return if no datas
    if (!$srcset || !$sourceType || !$originalSrc || !$width || !$height) {
        return array(
            'srcset' => $stringSrcset,
            'src' => $stringSrc,
            'sizes' => $stringSizes,
            'width' => $stringWidth,
            'height' => $stringHeight,
        );
    }

    // assign the sizes
    $stringSizes = $settings['sizes'] ?? '';

    // work out ratio cropping
    if (!empty($settings['ratio'])) {
        if ($settings['ratio'] === "1:1") {
            if ($height > $width) {
                $width = $height;
            } else {
                $height = $width;
            }
        }
        if ($settings['ratio'] === "16:9") {
            $height = round($width * (16/9));
        }

        // because we're limiting with a dimension, we need to crop
        if(empty($settings['fit'])) {
            $settings['fit'] = 'crop';
        }
        if(empty($settings['crop'])) {
            $settings['crop'] = 'faces,entropy';
        }
    }

    if (empty($settings['auto'])) {
        $settings['auto'] = 'compress';
    }

    if (empty($settings['q'])) {
        $settings['q'] = '45';
    }

    // now, based on the source type, generate URLs as needed
    if ($sourceType === 'placeholder') {
        // for place holders its a bit dumb because its not passing through a service
        foreach ($srcset as $size):
            $stringSrcset .= "//placehold.dev.area17.com/image/".$size."x".round(($height/$width) * $size)." ".$size."w, ";
        endforeach;

        $stringSrc = "//placehold.dev.area17.com/image/".$LQIPDimension."x".round(($height/$width) * $LQIPDimension);
    }

    if ($sourceType === 'imgix') {
        /*
            to build the urls, will need:

            $originalSrc
            $width
            $height
            $settings['fit']
            $settings['crop']
            $settings['crop']
            $settings['auto']
            $settings['q']

            nb: the src wants to have lower settings

            $settings['q'] = 10;
            $settings['blur'] = 75;
        */
    }

    if ($sourceType === 'lakeview') {
        /*
            to build the urls, will need:

            $originalSrc
            $width
            $height
            $settings['fit']
            $settings['crop']
            $settings['crop']
            $settings['auto']
            $settings['q']

            nb: the src wants to have lower settings

            $settings['q'] = 10;
            $settings['blur'] = 75;
        */
    }

    return array(
        'srcset' => $stringSrcset,
        'src' => $stringSrc,
        'sizes' => $stringSizes,
        'width' => $stringWidth,
        'height' => $stringHeight,
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
        $sizes .= ($name === 'xsmall' ? '' : ', '). $point .' '. $thisSize;
    endforeach;

    return $sizes;
}

/***

aic_gridListingImageSizes

Outputs a string for the sizes attribute of an image, in a grid listing

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

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

aic_imageSrcSet

Outputs a string for the srcset attribute of an image

AND

Outputs a string for the LQIP src of an image

```
    $srcsetAndSource = aic_imageSrcSet(array(
        'srcset' => $srcset,
        'image' => $image,
    ));

    $srcset = $srcsetAndSource['srcset'];
    $src = $srcsetAndSource['src'];
```


***/

function aic_imageSrcSet($data) {

    $stringSrcset = '';
    $stringSrc = '';

    $srcset = $data['srcset'] ?? false;

    $sourceType = $data['image']['sourceType'] ?? false;
    $src = $data['image']['src'] ?? false;
    $width = $data['image']['width'] ?? false;
    $height = $data['image']['height'] ?? false;

    $LQIPDimension = 25;

    if (!$srcset || !$sourceType || !$src || !$width || !$height) {
        return array(
            'srcset' => $stringSrcset,
            'src' => $stringSrc,
        );
    }

    // now, based on the source type, generate URLs as needed
    if ($sourceType === 'placeholder') {
        // for place holders its a bit dumb because its not passing through a service
        foreach ($srcset as $size):
            $stringSrcset .= "//placehold.dev.area17.com/image/".$size."x".round(($width/$height) * $size)." ".$size."w, ";
        endforeach;

        $stringSrc = "//placehold.dev.area17.com/image/".$LQIPDimension."x".round(($width/$height) * $LQIPDimension)." ".$LQIPDimension."w";
    }

    if ($sourceType === 'imgix') {
        // do transformations
    }

    if ($sourceType === 'lakeview') {
        // do transformations
    }

    return array(
        'srcset' => $stringSrcset,
        'src' => $stringSrc,
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

<?php

function aic_imageSizesBreakpoints() {
    return array(
        'xsmall' => '',
        'small' => '(min-width: 600px)',
        'medium' => '(min-width: 900px)',
        'large' => '(min-width: 1200px)',
        'xlarge' => '(min-width: 1640px)',
    );
}

/***

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

***/

function aic_imageSizes($data) {
    $breakpoints = aic_imageSizesBreakpoints();
    $sizes = '';
    $xlargeMaxSize = 1500;
    $totalCSScolumns = 58;
    $outerGutterCSScolumns = 3;

    // breakpoints are fluid except xlagre
    // for all breakpoints, except xlarge, 1 CSS column is 100vw/64 * 1
    // at xlarge, 1 CSS column is 1500px/58
    // see _variables.scss and _grid.scss (@function colspan)

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
    $breakpoints = aic_imageSizesBreakpoints();
    $newData = array();
    $totalCSScolumns = 58;
    $gutterCSSColumns = 2;

    foreach ($breakpoints as $name => $point):
        if (array_key_exists($name, $data)) {
            $newData[$name] = ($totalCSScolumns - (($data[$name] - 1) * $gutterCSSColumns)) / $data[$name];
        } else {
            $newData[$name] = 58;
        }
    endforeach;

    $sizes = aic_imageSizes($newData);

    return $sizes;
}

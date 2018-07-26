/***

Common themes
=============

The fundamental structure of the front end build is using [A17 Boilerplate](https://www.npmjs.com/package/@area17/a17-boilerplate) with its dependency of [A17 Helpers](https://www.npmjs.com/package/@area17/a17-helpers) (a small library of JavaScript helpers).

Many atom/molecule/organism components allow you to alter the tag, font and set a variation CSS class. Some allow the setting of Google Tag Manager attributes and Schema.org itemprops.

```
@component('components.atoms._btn')
    @slot('variation', 'btn--full')
    @slot('tag', 'a')
    @slot('href', $ticketLink ?? 'https://sales.artic.edu/')
    @slot('gtmAttributes', 'data-gtm-event="event-buy-tickets" data-gtm-event-category="nav-cta-button"')
    {{ $buttonText ?? 'Buy tickets' }}
@endcomponent
```

Google Tag Manager attributes are picked up by JavaScript (ajaxPageLoad and googleTagManagerDataFromLink) and sent through to GTM accordingly (googleTagManager);

***/
/***

Stylesheets (`SCSS`)
--------------------

The SCSS is written using [BEM](http://getbem.com/) and everything is split into atoms, molecules and organisms, following [Brad Frost's Atomic Web Design](http://bradfrost.com/blog/post/atomic-web-design/) as the basis.

**NB**
The `SCSS` files are compiled, the NPM tasks will need to be run in order for updates to take effect.

***/
/***

JavaScript
----------

The JavaScript is vanilla and is split into:
* `behaviors`
* `functions`

A `head.js` sets up some global objects and [mustard tests](http://responsivenews.co.uk/post/18948466399/cutting-the-mustard) the browser. If the browser doesn't pass the feature test, JavaScript is essentially disabled and a [default stylesheet](https://github.com/area17/html4css) loads. If the browser passes, then `picturefill` and the SVG sprite are loaded. `head.js` is tiny (< 2kb) and is inlined.

`app.js` continues the set up, initialises behaviors, font load observers, some global listeners and a lazy loader.

`functions` are local helper functions that either run all the time (eg: listening for requests to scroll to an anchor) or are repeated functions used in other functions.

`behaviors` are bound to DOM nodes on DOM ready:

```
<button data-behavior="globalSearchOpen" aria-label="Search site">
    ...
</button>
```

`behaviors/globalSearchOpen` will be run, passing through the DOM node as `container` to the function. Each `behavior` follows a similar structure.

They each have an `init` and a `destroy` function to add and remove behavior specific listeners. As the site has XHR page loads, then the JS will track which DOM nodes are added and removed, triggering `init` and `destroy` as needed. The JS listens for a `page:updated` event to run this check.

**NB**
The `JS` files are compiled, the NPM tasks will need to be run in order for updates to take effect.

***/
/***

Fonts
-----

Fonts are served from my.fonts.net and cloud.typography.com. The site will load with fallback fonts, a font observer JavaScript waits for fonts to load and adds a class to the body to switch to the correct fonts. We prefer a FOUT (flash of unstyled text) over FOIT (flash of invisible text) so that a site remains readable and usable.

***/
/***

The vertical grid
-----------------

The main container of the site is 58 columns. There are 3 columns either side, the outergutter, so in total the screen is split into 64 columns.

The 58 main container columns are CSS columns.

From these 58, we make 12 DESIGN columns of 3 CSS columns with 2 CSS columns gutter between them.

We also have 4 column GRID listings, where each item takes up 3 DESIGN columns (13 CSS columns) with 2 CSS column gutters between them.

***/
/***

Images
------

Images are responsive, they have some combo of `data-srcset`/`srcset` and `sizes`. The A17 lazyload helper updates the `data-srcset` to `srcset` when the image is visible. 

Many images have an `imageSettings` slot:

```
@component('components.molecules._m-media')
  @slot('item', $hours['media'])
  @slot('imageSettings', array(
      'fit' => 'crop',
      'ratio' => '16:9',
      'srcset' => array(300,600,800,1200,1600,3000,4500),
      'sizes' => aic_imageSizes(array(
            'xsmall' => '58',
            'small' => '58',
            'medium' => '38',
            'large' => '28',
            'xlarge' => '28',
      )),
  ))
@endcomponent
```

These settings feed into a `aic_imageSettings` PHP helper function inside of `ImageHelpers` which works out how to fill in the `sizes` attribute and the `srcset`.

In that instance we're asking `imgix` to 16:9 crop an image, to the widths in the `srcset` array and generate a `sizes` attribute with the sizes in CSS columns per breakpoint.

The breakpoint names follow the CSS breakpoint names in `_variables.scss`. 

For [imgix](https://docs.imgix.com/apis/url) images you can optionally specify:
* `fit`, defaults to `crop`
* `crop`, defaults to `faces, edges, entropy`
* `auto`, defaults to `compress`
* `fm`, defaults to `jpg`
* `q`, defaults to `80`
* `bg`, defaults to none

When specifying the image sizes, using `aic_imageSizes` you can also pass `px` or `vw` values:

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

Alternatively you can specify image sizes using `aic_gridListingImageSizes` which outputs its values based on how many columns in your GRID listing. For example, at `small` the items are in a 2 column grid:

```
_________
| x | x |
| x | x |
| x | x |
---------
```

And at `medium` they're in a 3 column grid:

```
_____________
| x | x | x |
| x | x | x |
-------------
```

And at `large+` they're in a 4 column grid:

```
_________________
| x | x | x | x |
| x | x | x | x |
-----------------
```

Which would be:

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

`aic_imageSettings` then takes these settings and generates a series of URLS for your image. It handles `imgix`, `lakeview` and `placehold.area17.com`.

It also generates a LQIP image for the initial `src` of the image to be replaced as required by the `srcset` and the lazy loader.

Remember, responsive images aren't super obvious - for example, on a retina cell phone with a poor connection, the image may be 300px wide and so it may choose to display the 300w variant in order to display a representative image quicker. If the cell phone connection speed is good, then the browser may instead choose the 600w image to take advantage of the higher resolution screen. 

The `width` and `height` is important so the browser knows how to correctly scale the image to avoid repaints, jumping of the page, when the image loads. Set these to the original width and height of the source image. 

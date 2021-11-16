{{-- Here we check if the first, hero image has a width. Because in
  -- DamsImageService->getDimesions(), if the image is 404 not
  -- found in the DAMS it returns dimension of 0x0. In which case This
  -- whole block should be skipped.
  --}}
@if (isset($images) && $images && $images->first() && $images->first()['width'])

@php
$maxZoomWindowSize = (isset($maxZoomWindowSize) && $maxZoomWindowSize) ? $maxZoomWindowSize : 1280;
$style = "";
$maxZoomWindowSize = ($maxZoomWindowSize === -1) ? 1280 : $maxZoomWindowSize;
if ($maxZoomWindowSize > 843) {
    $mainImgSize = '100%';
} else {
    $mainImgSize = $maxZoomWindowSize.'px';
    $style .= 'max-width:'.$mainImgSize.';max-height:'.$mainImgSize.';';
}
@endphp

<{{ $tag ?? 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="headerGallery">
<div class="m-article-header__img">
      <div class="m-article-header__img-container" data-gallery-hero>
         @php
            $image = $images->first();
         @endphp
         @component('components.atoms._img')
            @slot('image', $image)
            @slot('style', $style)
            @slot('settings', array(
                'srcset' => ImageHelpers::aic_getSrcsetForImage($images->first(), $isPublicDomain ?? false),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '843px',
                      'large' => '843px',
                      'xlarge' => '843px',
                )),
            ))
            @if(isset($isZoomable) && $isZoomable && $maxZoomWindowSize >= 1280)
                @slot('dataAttributes', 'data-gallery-fullscreen')
            @endif
        @endcomponent
      </div>
    @if (isset($images->first()['creditUrl']))
        <a href="{{ $images->first()['creditUrl'] }}" class="m-article-header__img-credit f-caption" aria-label="credit" data-gallery-credit>
            {{ $images->first()['credit'] ?? $images->first()['creditUrl'] ?? '' }}
        </a>
    @else
        <span class="m-article-header__img-credit f-caption" aria-label="credit" data-gallery-credit>
            {{ $images->first()['credit'] ?? '' }}
        </span>
    @endif
      <h2 class="sr-only" id="h-image-actions">Image actions</h2>
      <ul class="m-article-header__img-actions" aria-labelledby="h-image-actions">
        @if(isset($isZoomable) && $isZoomable && $maxZoomWindowSize >= 1280)
        <li>
            @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--zoom--24')
              @slot('dataAttributes', 'data-gallery-fullscreen')
              @slot('ariaLabel', 'Open image full screen')
            @endcomponent
        </li>
        @endif

        @if(isset($moduleMirador) && $moduleMirador && isset($isZoomable) && $isZoomable)
        <li data-type="moduleMirador"
        @if(!isset($isPublicDomain) || !$isPublicDomain)
          data-restricted="true"
        @endif
        >
            @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--view-mirador')
              @slot('dataAttributes', 'data-gallery-moduleMirador')
              @slot('behavior', 'triggerMediaModal')
              @slot('ariaLabel', 'Mirador Viewer')
              @slot('gtmAttributes', 'data-gtm-event="mirador-open-modal" data-gtm-event-category="in-page"')
            @endcomponent
            <textarea style="display: none;">@component('components.molecules._m-viewer-mirador')
              @slot('style', $style)
              @slot('type', 'modal')
              @slot('cc', isset($isPublicDomain) ? $isPublicDomain : false)
              @slot('title', $title)
              @slot('manifest', $moduleMirador)
              @slot('defaultView', $defaultView)
            @endcomponent</textarea>
        </li>
        @endif

        @if(isset($module360) && $module360)
        <li data-type="module360"
        @if(!isset($isPublicDomain) || !$isPublicDomain)
          data-restricted="true"
        @endif
        >
            @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--view360')
              @slot('dataAttributes', 'data-gallery-module360')
              @slot('behavior', 'triggerMediaModal')
              @slot('ariaLabel', '360 Viewer')
              @slot('gtmAttributes', 'data-gtm-event="360-open-modal" data-gtm-event-category="in-page"')
            @endcomponent
            <textarea style="display: none;">@component('components.molecules._m-viewer-360')
              @slot('style', $style)
              @slot('type', 'modal')
              @slot('cc', isset($isPublicDomain) ? $isPublicDomain : false)
              @slot('title', $title)
            @endcomponent</textarea>
        </li>
        @endif

        @if(isset($module3d) && $module3d)
        <li data-type="module3d"
        @if(!isset($isPublicDomain) || !$isPublicDomain)
          data-restricted="true"
        @endif
        >
            @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--tour3d')
              @slot('dataAttributes', 'data-gallery-module3d')
              @slot('behavior', 'triggerMediaModal')
              @slot('ariaLabel', 'View 3D Module')
              @slot('gtmAttributes', 'data-gtm-event="3D-open-modal" data-gtm-event-category="in-page"')
            @endcomponent
            <textarea style="display: none;">@component('components.molecules._m-viewer-3d')
              @slot('type', 'modal')
              @slot('uid', $module3d->model_id)
              @slot('annotations', $module3d->annotation_list)
              @slot('cc', isset($isPublicDomain) ? $isPublicDomain : false)
              @slot('guided', $module3d->guided_tour)
              @slot('title', $title)
            @endcomponent</textarea>
        </li>
        @endif

        @if(isset($isPublicDomain) && $isPublicDomain)
        <li>
            @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--download--24')
              @slot('dataAttributes', 'data-gallery-download')
              @slot('ariaLabel', 'Download image')
            @endcomponent
        </li>
        @endif
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--share--24')
              @slot('dataAttributes', 'data-gallery-share')
              @slot('behavior', 'sharePage')
              @slot('ariaLabel', 'Share page')
          @endcomponent
        </li>
      </ul>
  </div>
  <ul class="m-article-header__img-thumbs{{ (sizeof($images) === 1) ? ' s-single-img' : ''}}" data-behavior="dragScroll" data-gallery-thumbs>
      @foreach ($images as $image)
        <li>
          @php
            // It's ok for the thumbnail and the full-sized image to share the same srcset
            $galleryImageSrcset = ImageHelpers::aic_getSrcsetForImage($image, $isPublicDomain ?? false);
            $galleryImageThumbSettings = ImageHelpers::aic_imageSettings(array(
                'settings' => array(
                    'srcset' => $galleryImageSrcset,
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '58',
                          'medium' => '843px',
                          'large' => '843px',
                          'xlarge' => '843px',
                    ))
                ),
                'image' => $image,
            ));
          @endphp
          <button
            @if (isset($galleryImageThumbSettings['src']))
                data-gallery-img-src="{{ $galleryImageThumbSettings['lqip'] ?? $galleryImageThumbSettings['src'] }}"
            @endif
            @if (isset($galleryImageThumbSettings['srcset']))
                data-gallery-img-srcset="{{ $galleryImageThumbSettings['srcset'] }}"
            @endif
            @if (isset($galleryImageThumbSettings['width']))
                data-gallery-img-width="{{ $image['width'] }}"
            @endif
            @if (isset($galleryImageThumbSettings['height']))
                data-gallery-img-height="{{ $image['height'] }}"
            @endif
            @if (isset($image['credit']))
                data-gallery-img-credit="{{ $image['credit'] }}"
            @endif
            @if (isset($image['creditUrl']))
                data-gallery-img-credit-url="{{ $image['creditUrl'] }}"
            @endif
            @if (isset($image['shareUrl']))
                data-gallery-img-share-url="{{ $image['shareUrl'] }}"
            @endif
            @if (isset($image['shareTitle']))
                data-gallery-img-share-title="{{ $image['shareTitle'] }}"
            @endif
            @if (isset($image['downloadUrl']))
                data-gallery-img-download-url="{{ $image['downloadUrl'] }}"
            @endif
            @if (isset($image['downloadName']))
                data-gallery-img-download-name="{{ $image['downloadName'] }}"
            @endif
            @if (isset($image['iiifId']))
                data-gallery-img-iiifId="{{ $image['iiifId'] }}"
            @endif
            data-gtm-event="{{$image['shareTitle']}}"
            data-gtm-event-category="in-page"
            aria-label="show alternative image"
            disabled
          >Show this image</button>
          @component('components.atoms._img')
              @slot('image', $image)
              @slot('settings', array(
                'srcset' => $galleryImageSrcset,
                'sizes' => '400px',
              ))
          @endcomponent
        </li>
      @endforeach
  </ul>

</{{ $tag ?? 'header' }}>

@endif

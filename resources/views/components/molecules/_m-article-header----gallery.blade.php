{{--
     Here we check if the first, hero image has a width. Because in
     LakeviewImageService->getDimesions(), if the image is 404 not
     found in LAKE it returns dimension of 0x0. In which case This
     whole block should be skipped.
--}}
@if (isset($images) and $images and $images->first()['width'])

@php
$srcset = array_merge([200,400,843], (isset($isPublicDomain) && $isPublicDomain ? [1686] : []));
$maxZoomWindowSize = (isset($maxZoomWindowSize) && $maxZoomWindowSize) ? $maxZoomWindowSize : 1280;
$style = "";
$maxZoomWindowSize = ($maxZoomWindowSize === -1) ? 1280 : $maxZoomWindowSize;
if ($maxZoomWindowSize >= 843) {
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
                'lazyload' => false,
                'srcset' => $srcset,
                'sizes' => aic_imageSizes(array(
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
            @endcomponent
            <textarea style="display: none;">@component('components.molecules._m-viewer-3d')
              @slot('type', 'modal')
              @slot('uid', $module3d->model_id)
              @slot('annotations', $module3d->annotation_list)
              @slot('cc', isset($isPublicDomain) ? $isPublicDomain : false)
              @slot('guided', $module3d->guided_tour)
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
            $galleryImageThumbSettings = aic_imageSettings(array(
                'settings' => array(
                    'srcset' => $srcset,
                    'sizes' => aic_imageSizes(array(
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
            data-gtm-event="{{$image['shareTitle']}}" data-gtm-event-action="{{$title}}" data-gtm-event-category="in-page"
            aria-label="show alternative image"
            disabled
          >Show this image</button>
          @component('components.atoms._img')
              @slot('image', $image)
              @slot('settings', array(
                'lazyload' => false,
                'srcset' => array(300,600),
                'sizes' => '300px',
              ))
          @endcomponent
        </li>
      @endforeach
  </ul>

</{{ $tag ?? 'header' }}>

@endif

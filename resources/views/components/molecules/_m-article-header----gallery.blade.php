@if (isset($images) and $images)

@php
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

<{{ $tag or 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="headerGallery">
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
                'srcset' => array(200,423,846,1692,3000,6000),
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
      @if ($prevNextObject->next or $prevNextObject->prev)
      <ul class="m-article-header__img-nav">
        @if ($prevNextObject->next)
        <li class="m-article-header__img-nav-next-artwork">
          <a href="{!! route('artworks.show', ['id' => $prevNextObject->next->id, 'slug' => $prevNextObject->next->titleSlug ] + $prevNextObject->nextParams) !!}" class="m-article-header__img-nav-artwork-preview">
            <span class="sr-only">Next: </span>
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('image', $prevNextObject->next->imageFront())
                  @slot('settings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                  ))
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>{{ str_limit($prevNextObject->next->title, 18) }}</strong> <br>
              {{ str_limit($prevNextObject->next->listingSubtitle, 25) }}
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
        @endif
        @if ($prevNextObject->prev)
        <li class="m-article-header__img-nav-prev-artwork">
          <a href="{!! route('artworks.show', ['id' => $prevNextObject->prev->id, 'slug' => $prevNextObject->prev->titleSlug ] + $prevNextObject->prevParams) !!}" class="m-article-header__img-nav-artwork-preview">
            <span class="sr-only">Previous: </span>
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('image', $prevNextObject->prev->imageFront())
                  @slot('settings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                  ))
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>{{ str_limit($prevNextObject->prev->title, 18) }}</strong> <br>
              {{ str_limit($prevNextObject->prev->listingSubtitle, 25) }}
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
        @endif
      </ul>
      @endif
    @if (isset($images->first()['creditUrl']))
        <a href="{{ $images->first()['creditUrl'] }}" class="m-article-header__img-credit f-caption" aria-label="credit" data-gallery-credit>
            {{ $images->first()['credit'] ?? $images->first()['creditUrl'] ?? '' }}
        </a>
    @else
        <span class="m-article-header__img-credit f-caption" aria-label="credit" data-gallery-credit>
            {{ $images->first()['credit'] ?? '' }}
        </span>
    @endif
      <h3 class="sr-only" id="h-image-actions">Image actions</h3>
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
                    'srcset' => array(200,423,846,1692,3000,6000),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '58',
                          'medium' => '846px',
                          'large' => '846px',
                          'xlarge' => '846px',
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

</{{ $tag or 'header' }}>

@endif

@if (isset($images) and $images)

<{{ $tag or 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="headerGallery">

<div class="m-article-header__img">
      <div class="m-article-header__img-container" data-gallery-hero>
         @php
            $image = $images[0];
         @endphp
         @component('components.atoms._img')
            @slot('image', $image)
            @slot('settings', array(
                'lazyload' => false,
                'srcset' => array(200,423,846,1692,3000,6000),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '846px',
                      'large' => '846px',
                      'xlarge' => '846px',
                )),
            ))
        @endcomponent
      </div>
      @if (sizeof($images) > 1 or $nextArticle or $prevArticle)
      <ul class="m-article-header__img-nav">
        @if (sizeof($images) > 1)
        <li class="m-article-header__img-nav-next-img">
          <button data-gallery-next></button>
        </li>
        <li class="m-article-header__img-nav-prev-img">
          <button data-gallery-previous></button>
        </li>
        @endif
        @if ($nextArticle)
        <li class="m-article-header__img-nav-next-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('image', $nextArticle->imageFront())
                  @slot('settings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                  ))
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>{{ str_limit($nextArticle->title, 18) }}</strong> <br>
              {{ str_limit($nextArticle->subtitle, 25) }}
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
        @endif
        @if ($prevArticle)
        <li class="m-article-header__img-nav-prev-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('image', $prevArticle->imageFront())
                  @slot('settings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                  ))
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>{{ str_limit($prevArticle->title, 18) }}</strong> <br>
              {{ str_limit($prevArticle->subtitle, 25) }}
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
        @endif
      </ul>
      @endif
    @if (isset($images[0]['creditUrl']))
        <a href="{{ $images[0]['creditUrl'] }}" class="m-article-header__img-credit f-secondary" data-gallery-credit>
            {{ $images[0]['credit'] ?? $images[0]['creditUrl'] ?? '' }}
        </a>
    @else
        <span class="m-article-header__img-credit f-secondary" data-gallery-credit>
            {{ $images[0]['credit'] ?? '' }}
        </span>
    @endif
      <ul class="m-article-header__img-actions">
        <li>
            @if(isset($isZoomable) && $isZoomable)
                @component('components.atoms._btn')
                  @slot('variation', 'btn--septenary btn--icon-sq')
                  @slot('font', '')
                  @slot('icon', 'icon--zoom--24')
                  @slot('dataAttributes', 'data-gallery-fullscreen')
                @endcomponent
            @endif
        </li>
        <li>
            @if(isset($isPublicDomain) && $isPublicDomain)
                @component('components.atoms._btn')
                  @slot('variation', 'btn--septenary btn--icon-sq')
                  @slot('font', '')
                  @slot('icon', 'icon--download--24')
                  @slot('dataAttributes', 'data-gallery-download')
                @endcomponent
            @endif
        </li>
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--share--24')
              @slot('dataAttributes', 'data-gallery-share')
              @slot('behavior', 'sharePage')
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

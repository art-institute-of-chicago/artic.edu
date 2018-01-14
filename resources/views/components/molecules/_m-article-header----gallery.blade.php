@if (isset($images) and $images)

<{{ $tag or 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="headerGallery">

<div class="m-article-header__img">
      <div class="m-article-header__img-container" data-gallery-hero>
        @component('components.atoms._img')
            @slot('src', $images[0]['src'])
            @slot('srcset', $images[0]['srcset'])
            @slot('width', $images[0]['width'])
            @slot('height', $images[0]['height'])
        @endcomponent
      </div>
      <ul class="m-article-header__img-nav">
        <li class="m-article-header__img-nav-next-img">
          <button data-gallery-next></button>
        </li>
        <li class="m-article-header__img-nav-prev-img">
          <button data-gallery-previous></button>
        </li>
        @if ($nextArticle)
        <li class="m-article-header__img-nav-next-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('src', $nextArticle->image['src'])
                  @slot('srcset', $nextArticle->image['srcset'])
                  @slot('width', $nextArticle->image['width'])
                  @slot('height', $nextArticle->image['height'])
                  @slot('sizes', '120px')
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
                  @slot('src', $prevArticle->image['src'])
                  @slot('srcset', $prevArticle->image['srcset'])
                  @slot('width', $prevArticle->image['width'])
                  @slot('height', $prevArticle->image['height'])
                  @slot('sizes', '120px')
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
    @if ($images[0]['creditUrl'])
        <a href="{{ $images[0]['creditUrl'] }}" class="m-article-header__img-credit f-secondary" data-gallery-credit>
            {{ $images[0]['credit'] }}
        </a>
    @else
        <span class="m-article-header__img-credit f-secondary" data-gallery-credit>
            {{ $images[0]['credit'] }}
        </span>
    @endif
      <ul class="m-article-header__img-actions">
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--zoom--24')
              @slot('dataAttributes', 'data-gallery-fullscreen')
          @endcomponent
        </li>
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--arrow')
              @slot('dataAttributes', 'data-gallery-download')
          @endcomponent
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
  <ul class="m-article-header__img-thumbs{{ (sizeof($images) === 1) ? ' m-article-header__img-thumbs--single-img' : ''}}" data-gallery-thumbs>
      @foreach ($images as $image)
        <li>
          @component('components.atoms._img')
              @slot('src', $image['src'])
              @slot('srcset', $image['srcset'])
              @slot('width', $image['width'])
              @slot('height', $image['height'])
          @endcomponent
          <button
            data-gallery-img-srcset="{{ $image['srcset'] }}"
            data-gallery-img-credit="{{ $image['credit'] }}"
            data-gallery-img-credit-url="{{ $image['creditUrl'] }}"
            data-gallery-img-share-url="{{ $image['shareUrl'] }}"
            data-gallery-img-share-title="{{ $image['shareTitle'] }}"
            data-gallery-img-download-url="{{ $image['downloadUrl'] }}"
            data-gallery-img-download-name="{{ $image['downloadName'] }}"
            data-gallery-img-width="{{ $image['width'] }}"
            data-gallery-img-height="{{ $image['height'] }}"
            disabled
          >Show this image</button>
        </li>
      @endforeach
  </ul>

</{{ $tag or 'header' }}>

@endif

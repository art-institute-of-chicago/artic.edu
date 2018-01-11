<{{ $tag or 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="headerGallery">

  <div class="m-article-header__img">
      <div class="m-article-header__img-container" data-gallery-hero>
        @component('components.atoms._img')
            @slot('src', "http://placeimg.com/900/1600/nature")
            @slot('width', 900)
            @slot('height', 1600)
        @endcomponent
      </div>
      <span class="m-article-header__img-copyright f-secondary" data-gallery-credit>&copy; Art Institute of Chicago</span>
      <ul class="m-article-header__img-nav">
        <li class="m-article-header__img-nav-next-img">
          <button data-gallery-next></button>
        </li>
        <li class="m-article-header__img-nav-prev-img">
          <button data-gallery-previous></button>
        </li>
        <li class="m-article-header__img-nav-next-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('src', "http://placeimg.com/90/160/nature")
                  @slot('width', 90)
                  @slot('height', 160)
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>Head of an Apostle</strong> <br>
              French, Paris, 1312
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
        <li class="m-article-header__img-nav-prev-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('src', "http://placeimg.com/160/90/nature")
                  @slot('width', 160)
                  @slot('height', 90)
              @endcomponent
            </span>
            <span class="f-caption">
              <strong>Head of an Apostle</strong> <br>
              French, Paris, 1312
            </span>
            <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
          </a>
        </li>
      </ul>
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

  <ul class="m-article-header__img-thumbs" data-gallery-thumbs>
    <li>
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/900/1600/nature")
          @slot('width', 900)
          @slot('height', 1600)
      @endcomponent
      <button
        data-gallery-img-srcset="http://placeimg.com/900/1600/nature 900w"
        data-gallery-img-credit="&copy; Art Institute of Chicago"
        data-gallery-img-share-url="#"
        data-gallery-img-share-title="Nature"
        data-gallery-img-download-url="http://placeimg.com/900/1600/nature"
        data-gallery-img-download-name="Nature"
        data-gallery-img-width="900"
        data-gallery-img-height="1600"
        disabled
      >Show this image</button>
    </li>
    <li>
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/900/900/nature")
          @slot('width', 900)
          @slot('height', 900)
      @endcomponent
      <button
        data-gallery-img-srcset="http://placeimg.com/900/900/nature 900w"
        data-gallery-img-credit="&copy; AREA 17"
        data-gallery-img-share-url="#"
        data-gallery-img-share-title="Nature"
        data-gallery-img-download-url="http://placeimg.com/900/900/nature"
        data-gallery-img-download-name="Nature"
        data-gallery-img-width="900"
        data-gallery-img-height="900"
      >Show this image</button>
    </li>
    <li>
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/1600/900/nature")
          @slot('width', 1600)
          @slot('height', 900)
      @endcomponent
      <button
        data-gallery-img-srcset="http://placeimg.com/1600/900/nature 1600w"
        data-gallery-img-credit="Courtesy of Tate London"
        data-gallery-img-share-url="#"
        data-gallery-img-share-title="Nature"
        data-gallery-img-download-url="http://placeimg.com/1600/900/nature"
        data-gallery-img-download-name="Nature"
        data-gallery-img-width="1600"
        data-gallery-img-height="900"
      >Show this image</button>
    </li>
  </ul>

</{{ $tag or 'header' }}>

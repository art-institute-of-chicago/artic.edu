<{{ $tag or 'header' }} class="m-article-header m-article-header--gallery{{ (isset($variation)) ? ' '.$variation : '' }}">

  <div class="m-article-header__img">
      <div class="m-article-header__img-container">
        @component('components.atoms._img')
            @slot('src', "http://placeimg.com/900/1600/nature")
            @slot('width', 900)
            @slot('height', 1600)
        @endcomponent
      </div>
      <span class="m-article-header__img-copyright f-secondary">&copy; Art Institute of Chicago</span>
      <ul class="m-article-header__img-nav">
        <li class="m-article-header__img-nav-next-img">
          <button></button>
        </li>
        <li class="m-article-header__img-nav-prev-img">
          <button></button>
        </li>
        <li class="m-article-header__img-nav-next-artwork">
          <a href="#" class="m-article-header__img-nav-artwork-preview">
            <span class="m-article-header__img-nav-artwork-preview-img">
              @component('components.atoms._img')
                  @slot('src', "http://placeimg.com/90/160/nature")
                  @slot('width', 900)
                  @slot('height', 1600)
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
                  @slot('src', "http://placeimg.com/90/160/nature")
                  @slot('width', 900)
                  @slot('height', 1600)
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
          @endcomponent
        </li>
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--arrow')
          @endcomponent
        </li>
        <li>
          @component('components.atoms._btn')
              @slot('variation', 'btn--septenary btn--icon-sq')
              @slot('font', '')
              @slot('icon', 'icon--share--24')
          @endcomponent
        </li>
      </ul>
  </div>

  <ul class="m-article-header__imgs">
    <li class="s-active">
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/900/1600/nature")
          @slot('width', 900)
          @slot('height', 1600)
      @endcomponent
    </li>
    <li>
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/300/300/nature")
          @slot('width', 300)
          @slot('height', 300)
      @endcomponent
    </li>
    <li>
      @component('components.atoms._img')
          @slot('src', "http://placeimg.com/533/300/nature")
          @slot('width', 533)
          @slot('height', 300)
      @endcomponent
    </li>
  </ul>

</{{ $tag or 'header' }}>

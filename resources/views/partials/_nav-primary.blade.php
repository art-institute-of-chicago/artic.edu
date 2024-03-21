<nav
  class="g-header__nav-primary__container"
  aria-label="primary"
  data-behavior="primaryNavigation"
  data-api-url="{{ config('api.public_uri') }}"
>
  <a class="g-header__logo" aria-label="Art Institute of Chicago" href="/">
    <svg aria-hidden="true">
      <use xlink:href="#icon--logo--outline--80" />
      <use xlink:href="#icon--logo--outline--88" />
      <use xlink:href="#icon--logo--outline--92" />
    </svg>
  </a>
  <div class="g-header__nav-primary">
    <h2 class="sr-only" id="h-nav-primary-header">Primary Navigation</h2>
    <ul class="f-main-nav" aria-labelledby="h-nav-primary-header" role="menubar">
      @include('partials._navigation-list', [
        'role' => 'primary',
        'list' => $primaryNav,
        'eventCategory' => 'top-nav',
      ])
      <li class="u-show@small+">
        <button id="global-search-icon" data-behavior="globalSearchOpen" aria-label="Search site" role="menuitem">
          <svg class="icon--search--24" aria-hidden="true">
            <use xlink:href="#icon--search--24" />
          </svg>
        </button>
      </li>
    </ul>
  </div>
  <template id="menu-featured-exhibition">
    <a>
      <img aria-describedby="menu-featured-exhibition-title" alt="">
      <div class="description">
        <div class="supertitle">Featured Exhibition</div>
        <div id="menu-featured-exhibition-title" class="title"></div>
      </div>
    </a>
  </template>
</nav>

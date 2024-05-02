<div class="g-nav-mobile" data-behavior="navMobile" tabindex="0">
  <div class="g-nav-mobile__inner">
    <div class="g-nav-mobile__container">
      <div class="g-header">
        <div class="g-header__inner">
          <a class="g-header__logo" href="/">
            <svg aria-label="Art Institute of Chicago">
              <use xlink:href="#icon--logo--outline--80" />
              <use xlink:href="#icon--logo--outline--88" />
              <use xlink:href="#icon--logo--outline--92" />
            </svg>
          </a>
          @include('partials._nav-secondary')
        </div>
      </div>

      <div class="g-nav-mobile__search" data-behavior="mobileSearch">
        <form action="/search" role="search">
          <input type="search" id="mobile_search" name="q" placeholder="Search" autocomplete="off" aria-label="Search the site" />
          <button type="submit" aria-label="Search">
            <svg aria-hidden="true" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
          </button>
        </form>
      </div>

      <nav class="g-nav-mobile__nav-wrapper">
        <h2 class="sr-only" id="h-nav-mobile">Primary Navigation</h2>
        <ul class="g-nav-mobile__nav" aria-labelledby="h-nav-mobile">
          @include('partials._navigation-list', [
            'role' => 'primary',
            'list' => $primaryNav,
            'eventCategory' => 'top-nav',
          ])
        </ul>

        <div class="g-nav-mobile__nav-secondary">
          <h4 class="sr-only" id="h-footer-nav-secondary">Secondary Navigation</h4>
          <ul class="g-nav-mobile__legals" aria-labelledby="h-footer-nav-secondary">
            <li><a href="{{ $_pages['legal-press'] }}">Press</a></li>
            <li><a href="{{ $_pages['legal-employment'] }}">Careers</a></li>
            <li><a href="{{ $_pages['legal-contact'] }}">Contact</a></li>
            <li><a href="{{ $_pages['legal-venue-rental'] }}">Venue Rental</a></li>
            <li><a href="{{ $_pages['legal-image-licensing'] }}">Image Licensing</a></li>
            <li><a href="{{ $_pages['legal-saic'] }}">SAIC</a></li>
            <li><a href="{{ $_pages['legal-terms'] }}">Terms</a></li>
          </ul>

          <h4 class="sr-only" id="h-footer-nav-social">Social links</h4>
          <ul class="g-nav-mobile__social" aria-labelledby="h-footer-nav-social">
            @foreach(['Facebook', 'Twitter', 'Instagram', 'YouTube'] as $social)
              <li>
                <svg aria-hidden="true" class="icon--{{ strtolower($social) }}">
                  <use xlink:href="#icon--{{ ImageHelpers::getSocialIcon($_pages['follow-' . strtolower($social)]) }}"/>
                </svg>
                <a href="{{ $_pages['follow-' . strtolower($social)] }}">{{ $social }}</a>
              </li>
            @endforeach
          </ul>
        </div>
      </nav>

      <button class="g-nav-mobile__close" data-behavior="closeNavMobile" aria-label="Close menu">
        <svg aria-hidden="true" class="icon--close--24"><use xlink:href="#icon--close--24" /></svg>
      </button>
    </div>
  </div>
</div>

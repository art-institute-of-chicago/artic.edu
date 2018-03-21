<header class="g-header">
  <div class="g-header__inner">
      @if (isset($filledLogo) and $filledLogo)
      <a class="g-header__logo" href="/">
        <svg aria-title="Art Institute of Chicago">
          <use xlink:href="#icon--logo--80" />
          <use xlink:href="#icon--logo--88" />
          <use xlink:href="#icon--logo--92" />
        </svg>
      </a>
      @else
      <a class="g-header__logo" href="/">
        <svg aria-title="Art Institute of Chicago">
          <use xlink:href="#icon--logo--outline--80" />
          <use xlink:href="#icon--logo--outline--88" />
          <use xlink:href="#icon--logo--outline--92" />
        </svg>
      </a>
      @endif
      <nav class="g-header__nav-primary">
        <ul class="f-main-nav">
          <li class='u-hide@small+'><a href="#">Buy Tickets</a></li>
          <li{!! (isset($primaryNavCurrent) && $primaryNavCurrent == 'visit') ? ' class="s-current"' : '' !!}><a href="{{ $_pages['visit'] }}">Visit</a></li>
          <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'exhibitions_and_events') ? ' s-current' : '' }}"><a href="{{ $_pages['exhibitions'] }}">Exhibitions &amp; Events</a></li>
          <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'collection') ? ' s-current' : '' }}"><a href="{{ $_pages['collection'] }}">The Collection</a></li>
          <li class="u-show@small+"><button data-behavior="globalSearchOpen"><svg class="icon--search--24" aria-label="Search site"><use xlink:href="#icon--search--24" /></svg></button></li>
        </ul>
      </nav>
      <nav class="g-header__nav-secondary">
        <ul class="f-secondary">
          <li><a href="{{ $_pages['buy'] }}">Buy Tickets</a></li>
          <li><a href="{{ $_pages['become-a-member'] }}">Become a Member</a></li>
          <li><a href="{{ $_pages['shop'] }}">Shop</a></li>
        </ul>
      </nav>
      <p class="g-header__opening-hours f-secondary"><a href="{{ $_pages['visit'] }}">{!! $_hours['general'] !!}</a></p>
      <button class="g-header__menu-link f-secondary" data-nav-mobile-open>Menu<svg class="icon--menu--24"><use xlink:href="#icon--menu--24" /></svg></button>
  </div>
</header>

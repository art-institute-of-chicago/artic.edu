@php
    $_hours = [
        'general' => \App\Models\Hour::getOpeningUnlessClosure(),
        'url' => \App\Models\Hour::getOpeningUrl(),
        'closure' => \App\Models\Closure::today()->first(),
    ];
@endphp
<header class="g-header">
  <div class="g-header__inner">
      <a href="#content" class="skip-nav f-body">Skip to Content</a>
      <nav aria-label="primary">
        @if (isset($filledLogo) and $filledLogo)
        <a class="g-header__logo" aria-label="Art Institute of Chicago" href="/">
          <svg aria-hidden="true">
            <use xlink:href="#icon--logo--80" />
            <use xlink:href="#icon--logo--88" />
            <use xlink:href="#icon--logo--92" />
          </svg>
        </a>
        @else
        <a class="g-header__logo" aria-label="Art Institute of Chicago" href="/">
          <svg aria-hidden="true">
            <use xlink:href="#icon--logo--outline--80" />
            <use xlink:href="#icon--logo--outline--88" />
            <use xlink:href="#icon--logo--outline--92" />
          </svg>
        </a>
        @endif
        <div class="g-header__nav-primary">
          <h2 class="sr-only" id="h-nav-primary-header">Primary Navigation</h2>
          <ul class="f-main-nav" aria-labelledby="h-nav-primary-header">
            <li class='u-hide@small+'>
              <a href="{{ $_pages['buy'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="buy-tickets">Buy Tickets</a>
            </li>
            <li{!! (isset($primaryNavCurrent) && $primaryNavCurrent == 'visit') ? ' class="s-current"' : '' !!}>
              <a href="{{ $_pages['visit'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="visit">Visit</a>
            </li>
            <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'exhibitions_and_events') ? ' s-current' : '' }}">
              <a href="{{ $_pages['exhibitions'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="exhibitions-and-events">Exhibitions &amp; Events</a>
            </li>
            <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'collection') ? ' s-current' : '' }}">
              <a href="{{ $_pages['collection'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="collection">The Collection</a>
            </li>
            <li class="u-show@small+"><button data-behavior="globalSearchOpen" aria-label="Search site"><svg class="icon--search--24" aria-hidden="true"><use xlink:href="#icon--search--24" /></svg></button></li>
          </ul>
        </div>
      </nav>
      <nav class="g-header__nav-secondary" aria-label="secondary">
        <h2 class="sr-only" id="h-nav-secondary-header">Secondary Navigation</h2>
        <ul class="f-secondary" aria-labelledby="h-nav-secondary-header">
          <li><a href="{{ $_pages['buy'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="buy-tickets">Buy Tickets</a></li>
          <li><a href="{{ $_pages['become-a-member'] }}" data-gtm-event-category="top-nav" data-gtm-event-action="{{$seo->title}}" data-gtm-event="become-a-member">Become a Member</a></li>
          <li><a href="{{ $_pages['shop'] }}" target="_blank" data-gtm-event-action="{{$seo->title}}" data-gtm-event-category="top-nav" data-gtm-event="shop">Shop</a></li>
        </ul>
      </nav>
      <p class="g-header__opening-hours f-secondary"><a href="{{ $_hours['url'] }}">{!! $_hours['general'] !!}</a></p>
      <button class="g-header__menu-link f-secondary" data-behavior="openNavMobile" aria-label="Show menu">Menu<svg class="icon--menu--24" aria-hidden="true"><use xlink:href="#icon--menu--24" /></svg></button>
  </div>
  @if (isset($_hours['closure']))
  <div class="m-notification m-notification--header" data-behavior="notification">
    <div class="m-notification--header__inner">
      <p class="m-notification__text f-secondary">
        <svg class="icon--info" aria-hidden="true"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--info"></use></svg>{!! $_hours['closure']->present()->closureCopy ?? '' !!}
      </p>
      {{--
      <button class="m-notification__close" data-notification-closer=""><svg class="icon--close" aria-title="Close message"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--close"></use></svg></button>
      --}}
    </div>
  </div>
  @endif
</header>

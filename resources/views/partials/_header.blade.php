@php
    $_hours = [
        'closure' => app('closureservice')->getClosure(),
    ];
@endphp
<header class="g-header">
    <a href="#content" class="skip-nav f-body">Skip to Content</a>
    @if (isset($_hours['closure']) || config('aic.is_preview_mode'))
    <div class="m-notification m-notification--header" data-behavior="notification"{!! isset($_hours['closure']) ? ' data-notification-hash="' . md5($_hours['closure']) . '"' : '' !!}>
      <div class="m-notification--header__inner">
        <p class="m-notification__text f-secondary">
          <svg class="icon--info" aria-hidden="true"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--info"></use></svg>{!! config('aic.is_preview_mode') ? 'This a preview of unpublished content! Take care when sharing this link.' : ($_hours['closure']->present()->closureCopy ?? '') !!}
        </p>
        @if (!config('aic.is_preview_mode'))
          <button class="m-notification__close" data-notification-closer="" data-expires="1440"><svg class="icon--close" aria-title="Close message"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--close"></use></svg></button>
        @endif
      </div>
    </div>
    @endif
    <div class="g-header__inner">
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
              <a href="{{ $_pages['buy'] }}" data-gtm-event-category="top-nav" data-gtm-event="buy-tickets">Buy Tickets</a>
            </li>
            <li{!! (isset($primaryNavCurrent) && $primaryNavCurrent == 'visit') ? ' class="s-current"' : '' !!}>
              <a href="{{ $_pages['visit'] }}" data-gtm-event-category="top-nav" data-gtm-event="visit">Visit</a>
            </li>
            <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'exhibitions_and_events') ? ' s-current' : '' }}">
              <a href="{{ $_pages['exhibitions'] }}" data-gtm-event-category="top-nav" data-gtm-event="exhibitions-and-events">Exhibitions &amp; Events</a>
            </li>
            <li class="u-show@small+{{ (isset($primaryNavCurrent) && $primaryNavCurrent == 'collection') ? ' s-current' : '' }}">
              <a href="{{ $_pages['collection'] }}" data-gtm-event-category="top-nav" data-gtm-event="collection">The Collection</a>
            </li>
            <li class="u-show@small+"><button id="global-search-icon" data-behavior="globalSearchOpen" aria-label="Search site"><svg class="icon--search--24" aria-hidden="true"><use xlink:href="#icon--search--24" /></svg></button></li>
          </ul>
        </div>
      </nav>
      <nav class="g-header__nav-secondary" aria-label="secondary">
        <h2 class="sr-only" id="h-nav-secondary-header">Secondary Navigation</h2>
        <ul class="f-secondary" aria-labelledby="h-nav-secondary-header">
          <li><a href="{{ $_pages['buy'] }}" data-gtm-event-category="top-nav" data-gtm-event="buy-tickets">Buy Tickets</a></li>
          <li><a href="{{ $_pages['become-a-member'] }}" data-gtm-event-category="top-nav" data-gtm-event="become-a-member">Become a Member</a></li>
          <li><a href="{{ $_pages['shop'] }}" target="_blank" data-gtm-event-category="top-nav" data-gtm-event="shop">Shop</a></li>
        </ul>
      </nav>
      <button class="g-header__menu-link f-secondary" data-behavior="openNavMobile" aria-label="Show menu">Menu<svg class="icon--menu--24" aria-hidden="true"><use xlink:href="#icon--menu--24" /></svg></button>
  </div>
</header>

<div class="print-header">
    <div class="logo">
        {{-- Rather than using CSS to display SVGs, Prince XML requires the HTML to be inline --}}
        @php
            include base_path('frontend/icons/logo--outline--92.svg')
        @endphp
    </div>
    @if (isset($item) && is_object($item) && (get_class($item) == 'App\Models\Issue' || get_class($item) == 'App\Models\IssueArticle'))
        <div class="journal-logo">
            {{-- Rather than using CSS to display SVGs, Prince XML requires the HTML to be inline --}}
            @php
                include base_path('frontend/icons/journal-logo.svg')
            @endphp
        </div>
        <div class="issue-number f-module-title-2">
            Issue {{ $item->present()->issueNumber }}<br/>
            {{ $item->present()->issueTitle }}
        </div>
    @endif
</div>

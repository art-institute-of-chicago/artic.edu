@php
  $showHourSummary = config('aic.show_hours_in_footer')
    && !empty($hour)
    && trim(strip_tags($hour->summary));
@endphp

<footer id="footer" class="g-footer">
  <a href="#a17" class="g-footer__top-link arrow-link arrow-link--up f-small-caps">
    Back to top
    <span>
      <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
    </span>
  </a>

  <div class="g-footer__inner">
    <h2 class="sr-only" id="h-footer-grid">Footer content</h2>
    <ul class="g-footer__grid {!! $showHourSummary ? 'g-footer__grid--hours' : '' !!}" aria-labelledby="h-footer-grid">
      <li>
        <nav aria-label="primary">
          <h3 class="sr-only" id="h-footer-nav-primary">Primary Navigation</h3>

          <a class="g-footer__logo" aria-label="Art Institute of Chicago" href="/">
            <svg aria-hidden="true">
              <use xlink:href="#icon--logo--outline--92" />
            </svg>
          </a>

          <ul class="g-footer__link-list" aria-labelledby="h-footer-nav-primary">
            <li><a href="{{ $_pages['visit'] }}">Visit</a></li>
            <li><a href="{{ $_pages['exhibitions'] }}">Exhibitions and Events</a></li>
            <li><a href="{{ $_pages['collection'] }}">The Collection</a></li>
          </ul>
        </nav>
      </li>

      @if (!$showHourSummary)
        <li class="u-hide@small-">
          @component('partials._footer--locations')
            @slot('showMap', true)
          @endcomponent
        </li>

        <li class="u-hide@small-">
          <div class="g-footer__grid__group">
            @include('partials._footer--about')
          </div>

          <div class="g-footer__grid__group">
            @include('partials._footer--support')
          </div>
        </li>

        <li>
          <div class="g-footer__grid__group u-hide@small-">
            @include('partials._footer--learn')
          </div>

          <div class="g-footer__grid__group">
            @include('partials._footer--follow')
          </div>
        </li>
      @else
        <li>
          <div class="g-footer__grid__group">
            <h3 class="sr-only" id="h-footer-nav-hours">Hours</h3>
            <div class="g-footer__link-list g-footer__link-list--hours">
            {!! $hour->summary !!}
            </div>
          </div>

          <div class="g-footer__grid__group u-hide@small-">
            @component('partials._footer--locations')
              @slot('showMap', false)
            @endcomponent
          </div>
        </li>

        <li class="u-hide@small-">
          <div class="g-footer__grid__group">
            @include('partials._footer--about')
          </div>

          <div class="g-footer__grid__group u-hide@large+">
            @include('partials._footer--support')
          </div>
        </li>

        <li>
          <div class="g-footer__grid__group u-hide@small-">
            @include('partials._footer--learn')
          </div>

          <div class="g-footer__grid__group u-hide@large+">
            @include('partials._footer--follow')
          </div>
        </li>

        <li class="u-hide@medium-">
          <div class="g-footer__grid__group">
            @include('partials._footer--support')
          </div>
        </li>

        <li class="u-hide@medium-">
          <div class="g-footer__grid__group">
            @include('partials._footer--follow')
          </div>
        </li>
      @endif

    </ul>
  </div>

  <h2 class="sr-only" id="h-mobile-footer-links">Footer Links</h2>
  <ul class="g-footer__legals f-secondary" aria-labelledby="h-mobile-footer-links">
    <li><a href="{{ $_pages['legal-press'] }}">Press</a></li>
    <li><a href="{{ $_pages['legal-employment'] }}">Careers</a></li>
    <li><a href="{{ $_pages['legal-contact'] }}">Contact</a></li>
    <li><a href="{{ $_pages['legal-venue-rental'] }}">Venue Rental</a></li>
    <li><a href="{{ $_pages['legal-image-licensing'] }}">Image Licensing</a></li>
    <li><a href="{{ $_pages['legal-saic'] }}">SAIC</a></li>
    <li><a href="{{ $_pages['legal-terms'] }}">Terms</a></li>
  </ul>
</footer>
<a class="top-link" href="#a17" aria-label="top of page">
  <svg class="icon--arrow" aria-hidden="true">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow" />
  </svg>
</a>
